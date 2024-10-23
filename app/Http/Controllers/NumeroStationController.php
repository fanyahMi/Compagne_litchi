<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NumeroStation;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;

class NumeroStationController extends Controller
{
    public function index(){
        $compagnes = DB::table('compagne')
                    ->select('id_compagne', 'annee')
                    ->where('etat', '!=', 0)
                    ->get();

        $stations = DB::table('station')
                    ->select('id_station', 'station')
                    ->get();

        return view('station.Numero', compact('compagnes', 'stations'));
    }

    public function ajouteNumeroSation(Request $request){
        $validatedData = $request->validate([
            'compagne_id' => 'required|integer|exists:compagne,id_compagne',
            'station_id' => 'required|integer|exists:station,id_station',
            'numero_station' => 'required|integer',
        ], [
            'compagne_id.required' => 'Ce champ est obligatoire.',
            'station_id.required' => 'Ce champ est obligatoire.',
            'numero_station.required' => 'Ce champ est obligatoire.',
        ]);

        try {
            NumeroStation::ajouteNumeroStation($validatedData);

            return response()->json([
                'message' =>  "Numéro de station ajouté avec succès",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de l\'insertion des données: ' . $e->getMessage()
            ], 400);
        }
    }

    public function getNumero_station() {
        $numero_stations = NumeroStation::getListeNumeroStationCompagneEncoure();

        return response()->json($numero_stations);
    }

    public function getById($id){
        try {
            $numero_station = NumeroStation::findNumeroStation($id);
            return response()->json($numero_station);

        } catch (ModelNotFoundException $e) {
            echo $e->getMessage();
        }
    }
}
