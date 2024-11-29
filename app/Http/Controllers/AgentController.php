<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Log;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

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
        $roles =  DB::table('role')->select('id_role', 'role')->where('role', '!=', 'Administrateur')->get();

        return view('utilisateur.Agent', compact('sexes', 'situations','roles'));
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
                'id' => $result['id'],
            ]);
            return response()->json([
                'redirect' => url('/'),
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /*public function getAgent() {
        $agents = Agent::getAgentTableau();
        if ($agents === ' ') {
            return ' ';
        }
        return response()->json($agents);
    }*/
    public function getAgent(Request $request) {
        $name = $request->input('name');
        $sexe = $request->input('sexe');
        $role = $request->input('role');
        $perPage = $request->input('per_page', 2); // Par défaut, 10 éléments par page

        $agents = Agent::getAgentTableau($perPage, $name, $sexe, $role);

        if ($agents === ' ') {
            return response()->json(['message' => 'Les champs sont vides ou null.'], 400);
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
            'situation' => 'required|integer',
            'role' => 'required|integer'
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'dateNaissance.required' => 'La date de naissance est obligatoire.',
            'dateNaissance.before' => 'La personne doit être majeure.',
            'cin.required' => 'Le nº CIN est obligatoire.',
            'cin.digits' => 'Le nº CIN doit contenir 12 chiffres.',
            'cin.unique' => 'Le nº CIN existe déjà dans la base de données.'
        ]);


        try {

            Agent::ajouterAgent( $validatedData['nom'], $validatedData['prenom'], $validatedData['dateNaissance'], $validatedData['cin'], $validatedData['sexe'], $validatedData['situation'], $validatedData['role']);
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

    public function getById($id)    {
        try {
            $agent = Agent::getAgentById($id);
            return response()->json($agent);
        } catch (\Exception $e) {
            Log::error('Error fetching agent: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
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
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
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


    public function loginApi(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'matricule' => 'required|string',
            'mot_passe' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            $result = Agent::checkLoginWeb($request->matricule, $request->mot_passe);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        $payload = [
            'matricule' => $result['matricule'],
            'role' => $result['role'],
            'id' => $result['id'],
            'exp' => time() + (60 * Config::get('jwt.expiration')) // durée de vie du token
        ];

        $token = JWT::encode($payload,  Config::get('jwt.secret'), 'HS256');
        try {
            $decoded = JWT::decode($token, new Key(Config::get('jwt.secret'), 'HS256'));
        } catch (ExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (SignatureInvalidException $e) {
            return response()->json(['error' => 'Invalid token signature'], 401);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }


        return response()->json(['token' => $token, 'rep' => $decoded]);
    }

}
