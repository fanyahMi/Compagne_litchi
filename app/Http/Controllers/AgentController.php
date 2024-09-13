<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Exception;
use Log;

class AgentController extends Controller
{

    public function logout(Request $request)
    {
        $request->session()->forget('agent');
        return redirect('/login');
    }

    public function login(Request $request)
    {
        if (!$request->session()->has('agent')) {
            return view('login');
        }
        return redirect()->route('admin.index');
    }


    public function index(){
        $sexes = DB::table('sexe')->select('id_sexe', 'sexe')->get();
        $situations = DB::table('situation_familial')->select('id_situation_familial', 'situation_familial')->get();

        return view('utilisateur.Agent', compact('sexes', 'situations'));
    }

    public function loginWeb(Request $request)
    {
        $validatedData = $request->validate([
            'matricule' => 'required',
            'motDePasse' => 'required|string',
        ], [
            'matricule.required' => 'Le matricule est obligatoire.',
            'motDePasse.required' => 'Le mot de passe est obligatoire.',
            'motDePasse.string' => 'Le mot de passe doit être une chaîne de caractères.',
        ]);

        try {
            $result = Agent::checkLoginWeb($validatedData['matricule'], $validatedData['motDePasse']);
            $request->session()->put('agent', [
                'matricule' => $result['matricule'],
                'role' => $result['role'],
            ]);
            return response()->json([
                'redirect' => url('/'),
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getAgent() {
        $agents = Agent::orderBy('created_at', 'desc')->get();

        if ($agents->contains(function ($agent) {
            return in_array(null, $agent->toArray(), true) || in_array('', $agent->toArray(), true);
        })) {
            return ' ';
        }

        return response()->json($agents);
    }

    public function addAgent(Request $request) {
        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'nullable|string',
            'dateNaissance' => 'required|date|before:'.now()->subYears(18)->toDateString(),
            'cin' => 'required|digits:12',
            'sexe' => 'required',
            'situation' => 'required'
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'dateNaissance.required' => 'Date de naissance obligatoire.',
            'dateNaissance.before' => 'La personne doit être majeure.',
            'cin.required' => 'Le nº CIN obligatoire.',
            'cin.digits' => 'Le nº CIN doit contenir 12 chiffres.'
        ]);


        try {
            $numero = Agent::whereYear('created_at', now()->year)
                     ->whereMonth('created_at', now()->month)
                     ->count() + 1;

            $agent = Agent::create([
                'matricule' => Agent::generateMatricule($numero),
                'nom' => $validatedData['nom'],
                'prenom' => $validatedData['prenom'],
                'date_naissance' => $validatedData['dateNaissance'],
                'cin'=> $validatedData['cin'],
                'mot_passe' => $validatedData['cin'],
                'sexe_id' => $validatedData['sexe'],
                'role_id' => 2 ,
                'situation_familial_id' => $validatedData['situation'],
                'created_at' => now()
            ]);

            return response()->json([
                'message' => 'Agent ajouté avec succès',
                'agent' => $agent,
            ], 201);

        } catch (Exception $e) {
            // Log de l'erreur pour le débogage
            Log::error('Une erreur est survenue lors de l\'ajout de l\'agent : ' . $e->getMessage());

            // Retourne une réponse JSON en cas d'échec
            return response()->json(['error' => 'Erreur lors de l\'ajout de l\'agent: ' . $e->getMessage()], 400);
        }
    }

    public function dropAgent($id)
    {
        $agent = Agent::findOrFail($id);
        if ($agent) {
            $agent->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Agent supprimée avec succès.',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Agent non trouvée.',
        ], 404);
    }

}
