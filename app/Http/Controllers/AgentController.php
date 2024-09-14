<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
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
        $agents = Agent::getAgentTableau();
        if ($agents === ' ') {
            return ' ';
        }
        return response()->json($agents);
    }

    public function addAgent(Request $request) {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'dateNaissance' => 'required|date|before:'.now()->subYears(18)->toDateString(),
            'cin' => [
                'required',
                'digits:12',
                Rule::unique('utilisateur')
            ],
            'sexe' => 'required|integer',
            'situation' => 'required|integer'
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'dateNaissance.required' => 'La date de naissance est obligatoire.',
            'dateNaissance.before' => 'La personne doit être majeure.',
            'cin.required' => 'Le nº CIN est obligatoire.',
            'cin.digits' => 'Le nº CIN doit contenir 12 chiffres.',
            'cin.unique' => 'Le nº CIN existe déjà dans la base de données.'
        ]);


        try {

            Agent::ajouterAgent( $validatedData['nom'], $validatedData['prenom'], $validatedData['dateNaissance'], $validatedData['cin'], $validatedData['sexe'], $validatedData['situation']);
            return response()->json([
                'message' => 'Agent ajouté avec succès',
                       ], 200);

        } catch (Exception $e) {
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

    public function getById($id)
    {
        try {
            $agent = Agent::getAgentById($id);
            return response()->json($agent);
        } catch (\Exception $e) {
            Log::error('Error fetching agent: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id_utilisateur' => 'required|integer|exists:utilisateur,id_utilisateur',
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'dateNaissance' => 'required|date|before:'.now()->subYears(18)->toDateString(),
            'cin' => [
                'required',
                'digits:12',
                Rule::unique('utilisateur')->ignore($request->input('id_utilisateur'), 'id_utilisateur')
            ],
            'sexe' => 'required|integer',
            'situation' => 'required|integer',
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'dateNaissance.required' => 'Date de naissance obligatoire.',
            'dateNaissance.before' => 'La personne doit être majeure.',
            'cin.required' => 'Le nº CIN est obligatoire.',
            'cin.digits' => 'Le nº CIN doit contenir 12 chiffres.',
            'cin.unique' => 'Le nº CIN existe déjà dans la base de données.'
        ]);

        try {
            $id = $request->input('id_utilisateur');
            $data = $request->only(['nom', 'prenom', 'dateNaissance', 'cin', 'sexe', 'situation']);
            $agent = Agent::updateAgent($id, $data);
            return response()->json(['status' => 'success', 'message' => 'Agent mis à jour avec succès!', 'agent' => $agent]);
        } catch (\Exception $e) {
            Log::error('Error updating agent: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

}
