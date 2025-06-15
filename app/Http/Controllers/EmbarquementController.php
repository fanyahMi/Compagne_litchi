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

    public function modifierEmbarquement(Request $request, $idEmbarquement)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nombre_pallets' => 'required|integer|min:1',
            ],
            [
                'nombre_pallets.required' => 'Le champ "Nombre de palettes" est obligatoire.',
                'nombre_pallets.integer' => 'Le nombre de palettes doit être un entier.',
                'nombre_pallets.min' => 'Le nombre de palettes doit être au moins 1.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            $embarquement = Embarquement::findOrFail($idEmbarquement);
            $embarquement->nombre_pallets = $request->input('nombre_pallets');
            $embarquement->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Le nombre de palettes a été mis à jour avec succès.',
                'embarquement' => $embarquement
            ]);

        } catch (\Exception $e) {
            Log::error('Error during embarquement update: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de la mise à jour de l\'embarquement.'
            ]);
        }
    }

    public function dashboardEmbarquementNavire()
    {
        $calages = DB::select("
            SELECT 
                b.navire_id, 
                b.numero_cal, 
                SUM(b.nombre_pallets) as nombre_pallets
            FROM embarquement b
            JOIN mouvement_navire m 
                ON b.navire_id = m.navire_id
            WHERE m.date_depart IS NULL
            GROUP BY b.navire_id, b.numero_cal
            ORDER BY nombre_pallets DESC
            LIMIT 5
        ");

        // Requête pour l'entrée magasin
        $entreeMagasin = DB::select("
            SELECT 
                SUM(e.quantite_palette) as quantite_palette
            FROM entree_magasin e
            JOIN mouvement_navire m 
                ON e.navire_id = m.navire_id
            WHERE m.date_depart IS NULL
        ")[0]->quantite_palette ?? 0;

        // Requête pour la sortie magasin
        $sortieMagasin = DB::select("
            SELECT 
                SUM(sr.quantite_sortie) as quantite_palette
            FROM sortant_magasin sr
            JOIN entree_magasin e
                ON sr.entree_magasin_id = e.id_entree_magasin  
            JOIN mouvement_navire m 
                ON e.navire_id = m.navire_id
            WHERE m.date_depart IS NULL
        ")[0]->quantite_palette ?? 0;

        // Requête pour l'entrée shift
        $entreeShift = DB::select("
            SELECT 
                SUM(e.quantite_palette) as quantite_palette
            FROM entree_magasin e
            JOIN shift s 
                ON e.shift_id = s.id_shift
            JOIN mouvement_navire m 
                ON e.navire_id = m.navire_id
            WHERE m.date_depart IS NULL
        ")[0]->quantite_palette ?? 0;

        // Requête pour la sortie shift
        $sortieShift = DB::select("
            SELECT 
                SUM(sr.quantite_sortie) as quantite_palette
            FROM sortant_magasin sr
            JOIN shift s
                ON sr.shift_id = s.id_shift
            JOIN entree_magasin e
                ON sr.entree_magasin_id = e.id_entree_magasin  
            JOIN mouvement_navire m 
                ON e.navire_id = m.navire_id
            WHERE m.date_depart IS NULL
        ")[0]->quantite_palette ?? 0;

        // Requête pour l'embarquement shift
        $embarquementShift = DB::select("
            SELECT 
                SUM(b.nombre_pallets) as nombre_pallets
            FROM embarquement b
            JOIN mouvement_navire m 
                ON b.navire_id = m.navire_id
            JOIN shift s
                ON b.shift_id = s.id_shift
            WHERE m.date_depart IS NULL
        ")[0]->nombre_pallets ?? 0;

        // Requête pour les informations du navire
        $navireInfo = DB::select("
            SELECT 
                v.navire, 
                v.id_navire, 
                v.quotas_navire,
                SUM(e.nombre_pallets) AS total_pallets,
                ROUND((SUM(e.nombre_pallets) / NULLIF(v.quotas_navire, 0) * 100), 2) AS pourcentage_quota
            FROM v_quotas_navire_compagne AS v
            LEFT JOIN embarquement AS e ON v.id_navire = e.navire_id
            WHERE v.id_compagne = (
                SELECT c.id_compagne 
                FROM compagne c
                WHERE c.etat = 0
            ) AND v.id_navire = (
                SELECT mn.navire_id
                FROM mouvement_navire mn 
                WHERE mn.date_depart IS NULL
            )
            GROUP BY v.navire, v.id_navire, v.quotas_navire
        ")[0] ?? null;

        // Requête pour le graphique (mouvements par heure pour un shift spécifique)
        $chartData = DB::select("
            WITH heures AS (
                SELECT h.heure
                FROM (
                    SELECT 0 AS heure UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION 
                    SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION 
                    SELECT 10 UNION SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14 UNION 
                    SELECT 15 UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19 UNION 
                    SELECT 20 UNION SELECT 21 UNION SELECT 22 UNION SELECT 23
                ) h
            ),
            dates AS (
                SELECT DISTINCT date_embarquement AS date
                FROM embarquement
            ),
            combinaisons AS (
                SELECT d.date, h.heure, s.id_shift, s.description AS shift_description
                FROM dates d
                CROSS JOIN heures h
                CROSS JOIN shift s
            )
            SELECT 
                c.heure,
                COALESCE(COUNT(e.id_embarquement), 0) AS nombre_mouvements
            FROM combinaisons c
            LEFT JOIN embarquement e 
                ON e.date_embarquement = c.date 
                AND HOUR(e.heure_embarquement) = c.heure 
                AND e.shift_id = c.id_shift
            WHERE c.id_shift = 3
            GROUP BY c.heure
            ORDER BY c.heure
        ");

        // Préparer les données pour le graphique
        $chartLabels = array_map(function ($item) { return $item->heure . 'h'; }, $chartData);
        $chartValues = array_map(function ($item) { return $item->nombre_mouvements; }, $chartData);

        // Passer les données à la vue
        return view('embarquement.Embarquement', compact(
            'calages',
            'entreeMagasin',
            'sortieMagasin',
            'entreeShift',
            'sortieShift',
            'embarquementShift',
            'navireInfo',
            'chartLabels',
            'chartValues'
        ));
        //return view('');
    }
}
