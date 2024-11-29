<?php

namespace App\Http\Controllers;


use App\Models\Embarquement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Config;
use Log;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class EmbarquementController extends Controller
{
    public function rechercherHistoriqueCale(Request $request)
    {
        // Récupérer les paramètres de la requête
        $agent = $request->input('agent'); // Agent à rechercher (nom-prénom)
        $idStation = $request->input('id_station'); // Station ID
        $idShift = $request->input('id_shift'); // Shift ID
        $dateDebut = $request->input('date_debut'); // Plage de date début
        $dateFin = $request->input('date_fin'); // Plage de date fin
        $heureDebut = $request->input('heure_debut'); // Heure début
        $heureFin = $request->input('heure_fin');
        $idNavire =  $request->input('id_navire');
        $cale =  $request->input('cale');
        $idCompagne =  $request->input('id_compagne');

        // Construction de la requête de base
        $query = DB::table('v_historique_embarquement');

        $query->where('id_compagne', $idCompagne);
        $query->where('id_navire', $idNavire);
        $query->where('numero_cal', $cale);
        // Filtrage par agent si spécifié
        if ($agent) {
            $query->where(function ($q) use ($agent) {
                $q->whereRaw("agent LIKE ?", ["%$agent%"]);
            });
        }

        // Filtrage par station si spécifié
        if ($idStation) {
            $query->where('id_station', $idStation);
        }

        // Filtrage par shift si spécifié
        if ($idShift) {
            $query->where('id_shift', $idShift);
        }

        // Filtrage par date d'embarquement si spécifié
        if ($dateDebut && $dateFin) {
            $query->whereBetween('date_embarquement', [$dateDebut, $dateFin]);
        }

        // Filtrage par heure d'embarquement si spécifié
        if ($heureDebut && $heureFin) {
            $query->whereBetween('heure_embarquement', [$heureDebut, $heureFin]);
        }

        // Exécution de la requête et récupération des résultats
        $resultats = $query->get();

        // Retourner les résultats sous forme de JSON
        return response()->json($resultats);
    }
    public function rechercherHistoriqueNavire(Request $request)
    {
        // Récupérer les paramètres de la requête
        $idStation = $request->input('id_station'); // Station ID
        $idNavire =  $request->input('id_navire');
        $cale =  $request->input('cale');
        $idCompagne =  $request->input('id_compagne');
        // Construction de la requête de base
        $query = DB::table('v_historique_embarquement_navire');

        $query->where('id_compagne', $idCompagne);

        $query->where('id_navire', $idNavire);
        $query->where('numero_cal', $cale);

        // Filtrage par station si spécifié
        if ($idStation) {
            $query->where('id_station', $idStation);
        }

        // Exécution de la requête et récupération des résultats
        $resultats = $query->get();

        // Retourner les résultats sous forme de JSON
        return response()->json($resultats);
    }

    public function embarquer(Request $request){
        // Validation des données entrantes
        $validator = Validator::make($request->all(), [
            'station_id' => 'required|exists:station,id_station',
            'navire_id' => 'required|exists:navire,id_navire',
            'numero_cal' => 'required|integer',
            'nombre_pallets' => 'required|integer|min:1',
        ]);

        // Vérifier si la validation échoue
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try { $compagne = DB::table('compagne')
            ->where('etat', 1)
            ->first();
            $currentShift = DB::table('shift')
            ->where(function ($query) {
                // Shifts dans la même journée
                $query->whereRaw('CURRENT_TIME >= debut AND CURRENT_TIME <= fin');
            })
            ->orWhere(function ($query) {
                // Shifts traversant minuit
                $query->whereRaw('debut > fin AND (CURRENT_TIME >= debut OR CURRENT_TIME <= fin)');
            })
            ->first();

            $token = $request->bearerToken();

$decoded = JWT::decode($token, new Key(Config::get('jwt.secret'), 'HS256'));
// Créer un nouvel enregistrement dans la table embarquement
/*$embarquement = Embarquement::create([
    'utilisateur_id' => $decoded->id,
    'compagne_id' => $compagne,
    'shift_id' => $currentShift,
    'station_id' => $request->station_id,
    'navire_id' => $request->navire_id,
    'numero_cal' => $request->numero_cal,
    'nombre_pallets' => (int)$request->nombre_pallets
]);*/

// Retourner une réponse avec l'enregistrement créé
return response()->json($decoded->id, 201); //code...
        } catch (\Exception $e) {
            Log::error('Error fetching agent: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }

    }

}
