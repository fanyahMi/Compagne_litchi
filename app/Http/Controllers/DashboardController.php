<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupérer la campagne en cours (par exemple, la plus récente)
        $currentCampagne = DB::table('compagne')
            ->select('id_compagne', 'annee')
            ->where('etat', 1)
            ->first();

        // Récupérer toutes les campagnes pour le filtre
        $campagnes = DB::table('compagne')
            ->select('id_compagne', 'annee', 'etat')
            ->get();

        // Récupérer tous les navires pour le filtre
        $navires = DB::table('navire')
            ->select('id_navire', 'navire')
            ->get();

        return view('station.TableauDeBoard', compact(
            'currentCampagne',
            'campagnes',
            'navires',
        ));
    }

    public function getQuotasData(Request $request)
    {
        $compagneId = $request->input('id_compagne');
        $navireId = $request->input('id_navire');

        $query = DB::table('v_quotas_navire_compagne as v')
            ->select(
                'v.navire',
                'v.id_navire',
                DB::raw('SUM(e.nombre_pallets) as total_pallets'),
                'v.quotas_navire',
                DB::raw('ROUND((SUM(e.nombre_pallets) / v.quotas_navire * 100), 2) as pourcentage_quota'),
                'e.numero_station_id',
                's.station',
                DB::raw('SUM(e.nombre_pallets) as pallets_par_station')
            )
            ->leftJoin('embarquement as e', 'v.id_navire', '=', 'e.navire_id')
            ->leftJoin('numero_station as ns', 'ns.id_numero_station', '=', 'e.numero_station_id')
            ->leftJoin('station as s', 'ns.station_id', '=', 's.id_station')
            ->where('v.id_compagne', $compagneId);
            
        if ($navireId) {
            $query->where('v.id_navire', $navireId);
        }

        $results = $query
            ->groupBy('v.navire', 'v.id_navire', 'v.quotas_navire', 'e.numero_station_id', 's.station')
            ->orderBy('v.navire')
            ->orderBy('e.numero_station_id')
            ->get();

        $navires = [];
        $totalPallets = [];
        $quotas = [];
        $pourcentages = [];
        $stationsLabels = [];
        $stationsData = [];
        $totalPalletsSum = 0;
        $pourcentageSum = 0;
        $stationsSet = [];

        foreach ($results as $row) {
            $navire = $row->navire;
            if (!in_array($navire, $navires)) {
                $navires[] = $navire;
                $totalPallets[] = $row->total_pallets;
                $quotas[] = $row->quotas_navire;
                $pourcentages[] = $row->pourcentage_quota;
                $totalPalletsSum += $row->total_pallets;
                $pourcentageSum += $row->pourcentage_quota;
            }
            $station = $row->station ?? 'Inconnue';
            if (!in_array($station, $stationsLabels)) {
                $stationsLabels[] = $station;
                $stationsSet[] = $station;
            }
            $stationsData[$navire][$station] = $row->pallets_par_station;
        }

        return response()->json([
            'navires' => $navires,
            'total_pallets_data' => $totalPallets,
            'quotas' => $quotas,
            'pourcentages' => $pourcentages,
            'stations_labels' => $stationsLabels,
            'stations_data' => $stationsData,
            'total_pallets' => $totalPalletsSum,
            'avg_pourcentage' => count($pourcentages) ? round($pourcentageSum / count($pourcentages), 2) : 0,
            'stations_count' => count($stationsSet)
        ]);
    }

    public function getMouvements(Request $request)
    {
        $compagneId = $request->input('id_campagne');
        $navireId = $request->input('id_navire');
        $cale = $request->input('cale');
        $stationId = $request->input('id_station');
        $shiftId = $request->input('id_shift');
        $agent = $request->input('agent');
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        $page = $request->input('page', 1);

        $query = DB::table('embarquement as e')
            ->select(
                'e.numero_cale',
                'e.numero_station_id',
                's.station',
                'sh.description',
                'e.matricule',
                'e.prenom',
                'e.embarquement',
                'e.nombre_pallets'
            )
            ->leftJoin('numero_station as ns', 'ns.id_numero_station', '=', 'e.numero_station_id')
            ->leftJoin('station as s', 'ns.station_id', '=', 's.id_station')
            ->leftJoin('shift as sh', 'sh.id_shift', '=', 'e.shift_id')
            ->where('e.id_campagne', $compagneId);

        if ($navireId) {
            $query->where('e.navire_id', $navireId);
        }
        if ($cale) {
            $query->where('e.numero_cale', $cale);
        }
        if ($stationId) {
            $query->where('e.numero_station_id', $stationId);
        }
        if ($shiftId) {
            $query->where('e.shift_id', $shiftId);
        }
        if ($agent) {
            $query->where(function ($q) use ($agent) {
                $q->where('e.matricule', 'like', "%$agent%")
                  ->orWhere('e.prenom', 'like', "%$agent%");
            });
        }
        if ($dateDebut) {
            $query->whereDate('e.embarquement', '>=', $dateDebut);
        }
        if ($dateFin) {
            $query->whereDate('e.embarquement', '<=', $dateFin);
        }

        $perPage = 10;
        $mouvements = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($mouvements);
    }
}