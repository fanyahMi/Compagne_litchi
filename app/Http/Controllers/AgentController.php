<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Validation\ValidationException;
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
        return view('utilisateur.Agent');
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

    public function getAgent(){

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
            'dateNaissance.before' => 'La personne doit être majeure.',
            'cin.digits' => 'Le nº CIN doit contenir 12 chiffres.'
        ]);


        try {
            // Traitement des données validées (ex: enregistrement en base de données)
            // Exemple : Agent::create($validatedData);

            // Retourne une réponse JSON en cas de succès
            return response()->json(['message' => 'Agent ajouté avec succès'], 201);
        } catch (Exception $e) {
            // Log de l'erreur pour le débogage
            Log::error('Une erreur est survenue lors de l\'ajout de l\'agent : ' . $e->getMessage());

            // Retourne une réponse JSON en cas d'échec
            return response()->json(['error' => 'Erreur lors de l\'ajout de l\'agent: ' . $e->getMessage()], 400);
        }
    }

}
