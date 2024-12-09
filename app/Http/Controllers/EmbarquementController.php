<?php

namespace App\Http\Controllers;


use App\Models\Embarquement;
use App\Models\Navire;
use App\Models\Shift;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Log;


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
        $idCompagne =  $request->input('id_campagne');

        // Construction de la requête de base
        $query = DB::table('v_historique_embarquement'); //date_embarquement

        $query->where('id_compagne', $idCompagne);
        $query->where('id_navire', $idNavire);
        $query->where('numero_cal', $cale);

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

        $query->orderBy('date_embarquement', 'desc')
            ->orderBy('heure_embarquement', 'desc');

        // Exécution de la requête et récupération des résultats
        $resultats = $query->get();

        // Retourner les résultats sous forme de JSON
        return response()->json($resultats);
    }
    public function rechercherHistoriqueNavire(Request $request)
    {
        $idStation = $request->input('id_station');
        $idNavire =  $request->input('id_navire');
        $idCompagne =  $request->input('id_campagne');
        $query = DB::table('v_historique_embarquement_navire');

        $query->where('id_compagne', $idCompagne);

        $query->where('id_navire', $idNavire);

        if ($idStation) {
            $query->where('id_station', $idStation);
        }

        $resultats = $query->get();

        return response()->json($resultats);
    }

    public function embarquer(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'numero_station_id' => 'required|array|min:1',
                'numero_station_id.*' => 'exists:numero_station,id_numero_station',
                'navire_id' => 'required|exists:navire,id_navire',
                'numero_cal' => 'required|integer',
                'nombre_pallets' => 'required|array|min:1',
                'nombre_pallets.*' => 'integer|min:1',
            ],
            [
                'numero_station_id.required' => 'Le champ "Numéro de la station" est obligatoire.',
                'numero_station_id.array' => 'Le champ "Numéro de la station" doit être un tableau.',
                'numero_station_id.*.exists' => 'Un ou plusieurs numéros de station sont invalides.',
                'navire_id.required' => 'Le champ "Navire" est obligatoire.',
                'navire_id.exists' => 'Le navire spécifié est invalide.',
                'numero_cal.required' => 'Le champ "Numéro CAL" est obligatoire.',
                'numero_cal.integer' => 'Le numéro CAL doit être un nombre entier.',
                'nombre_pallets.required' => 'Le champ "Nombre de palettes" est obligatoire.',
                'nombre_pallets.array' => 'Le champ "Nombre de palettes" doit être un tableau.',
                'nombre_pallets.*.integer' => 'Chaque élément de "Nombre de palettes" doit être un nombre entier.',
                'nombre_pallets.*.min' => 'Chaque élément de "Nombre de palettes" doit être au moins 1.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            $currentShift = DB::table('shift')
                ->where(function ($query) {
                    $query->whereRaw('CURRENT_TIME >= debut AND CURRENT_TIME <= fin');
                })
                ->orWhere(function ($query) {
                    $query->whereRaw('debut > fin AND (CURRENT_TIME >= debut OR CURRENT_TIME <= fin)');
                })
                ->value('id_shift'); // Récupère seulement l'id du shift actuel

            $user = $request->get('user');

            $stations = $request->input('numero_station_id'); // Tableau des numéros de station
            $pallets = $request->input('nombre_pallets');     // Tableau des quantités de palettes

            if (count($stations) !== count($pallets)) {
                return response()->json([
                    'error' => 'Le nombre de stations doit correspondre au nombre de palettes.'
                ], 400);
            }

            $embarquements = [];
            foreach ($stations as $index => $stationId) {
                $embarquements[] = [
                    'utilisateur_id' => $user->id,
                    'shift_id' => $currentShift,
                    'numero_station_id' => $stationId,
                    'navire_id' => $request->navire_id,
                    'numero_cal' => $request->numero_cal,
                    'nombre_pallets' => (int)$pallets[$index]
                ];
            }

            Embarquement::insert($embarquements);

            return response()->json(['status' => 'success'], 201);

        } catch (\Exception $e) {
            Log::error('Error during embarquement: ' . $e->getMessage());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function affichageHistoriqueNavire($idCampagne){
        $compagne = DB::table('compagne')
            ->where('id_compagne',$idCampagne)
            ->first();
        $campagne =   $compagne->annee;
        $navires = Navire::all();
        return view('station.HistoriqueNavire', compact('idCampagne', 'campagne',  'navires'));
    }

    public function getNavireHistorique(Request $request){
        $idCampagne = $request->input('id_campagne');
        $idNavire = $request->input('id_navire');
        $perPage = $request->input('per_page', 10);
        $query = DB::table('v_mouvement_navire');
        $query->where('id_compagne', $idCampagne);
        if(!empty($idNavire)){
            $query->where('id_navire', $idNavire);
        }
        $historique = $query->paginate($perPage);
        return response()->json($historique);
    }

    public function affichageDetailCalesHistorique($idCampagne, $idNavire){
        $cales = DB::table('v_quantite_cales')
            ->where('id_navire', '=', $idNavire)
            ->where('id_compagne', '=', $idCampagne)
            ->get();
        $shifts = Shift::all();
        $compagne = DB::table('compagne')
            ->where('id_compagne',$idCampagne)
            ->first();
        $campagne =   $compagne->annee;
        $nav = DB::table('navire')
                ->where('id_navire',$idNavire)
                ->first();
        $navire = $nav->navire;
        $normal_stations =  Station::all();

        return view('station.DetailCaleHistorique', compact('idCampagne', 'idNavire', 'cales', 'shifts' , 'campagne', 'navire', 'normal_stations'));
    }

    public function affichageDetailHistoriqueCales(Request $request){
        $idCampagne = $request->input('id_campagne');
        $idNavire =  $request->input('id_navire');
        $cale =  $request->input('cale');
        $perPage = $request->input('per_page', 1);
        $idStation = $request->input('id_station');
        $query = DB::table('v_historique_embarquement_navire');
        $query->where('id_compagne', $idCampagne);

        $query->where('id_navire', $idNavire);

        if ($idStation) {
            $query->where('id_station', $idStation);
        }
        if ($cale) {
            $query->where('numero_cal', $cale);
        }
        $historique = $query->paginate($perPage);
        return response()->json($historique);
    }


    public function affichageDetailCale(Request $request){
        $idCampagne = $request->input('id_campagne');
        $idNavire =  $request->input('id_navire');
        $cale =  $request->input('cale');
        $idShift = $request->input('id_shift');
        $idStation = $request->input('id_station');
        $agent = $request->input('agent');
        $perPage = $request->input('per_page', 10);
        $dateDebut = $request->input('date_debut'); // Plage de date début
        $dateFin = $request->input('date_fin'); // Plage de date fin

        $query = DB::table('v_historique_embarquement');



        $query->where('id_compagne', $idCampagne);
        $query->where('id_navire', $idNavire);
        if ($cale) {
            $query->where('numero_cal', $cale);
        }

        if ($agent) {
            $query->where(function ($q) use ($agent) {
                $q->whereRaw("agent LIKE ?", ["%$agent%"]);
            });
        }

        if ($idStation) {
            $query->where('id_station', $idStation);
        }

        if ($idShift) {
            $query->where('id_shift', $idShift);
        }

        if ($dateDebut && $dateFin) {
            $query->whereBetween('date_embarquement', [$dateDebut, $dateFin]);
        }



        $query->orderBy('date_embarquement', 'desc')
            ->orderBy('heure_embarquement', 'desc');

            $historique = $query->paginate($perPage);
            return response()->json($historique);

    }

}
