<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NumeroStation;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Log;
use Exception;

class NumeroStationController extends Controller
{
    public function index(){
        $compagnes = DB::table('compagne')
                    ->select('id_compagne', 'annee')
                    ->get();

        $stations = DB::table('station')
                    ->select('id_station', 'station')
                    ->get();

        return view('station.Numero', compact('compagnes', 'stations'));
    }

    public function ajouteNumeroSation(Request $request){
        $validator = Validator::make($request->all(),[
            'compagne_id' => 'required|integer|exists:compagne,id_compagne',
            'station_id' => [
                'required',
                'integer',
                'exists:station,id_station',
                Rule::unique('numero_station', 'station_id')
                    ->where(function ($query) use ($request) {
                        $query->where('compagne_id', $request->compagne_id);
                    }),
            ],
            'numero_station' => [
                'required',
                'integer',
                Rule::unique('numero_station', 'numero_station')
                    ->where(function ($query) use ($request) {
                        $query->where('compagne_id', $request->compagne_id);
                    }),
            ],
        ], [
            'compagne_id.required' => 'Ce champ est obligatoire.',
            'station_id.required' => 'Ce champ est obligatoire.',
            'numero_station.required' => 'Ce champ est obligatoire.',
            'station_id.unique' => 'Cette station est déjà utilisée pour cette compagne.',
            'numero_station.unique' => 'Ce numéro de station est déjà utilisé pour cette compagne.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            $data = $request->only(['compagne_id', 'station_id', 'numero_station']);
            NumeroStation::ajouteNumeroStation($data);

            return response()->json([
                'message' =>  "Numéro de station ajouté avec succès",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de l\'insertion des données: ' . $e->getMessage()
            ], 400);
        }
    }

    public function getNumero_station(Request $request) {

        $compagne = $request-> input('compagne');
        $perPage = $request->input('per_page', 10);

        $numero_stations = NumeroStation::getListeNumeroStation($perPage, $compagne);
        if ($numero_stations === ' ') {
            return response()->json(['message' => 'Les champs sont vides ou null.'], 400);
        }

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

    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'id_numero_station' => 'required|integer|exists:numero_station,id_numero_station',
            'compagne_id' => 'required|integer|exists:compagne,id_compagne',
            'station_id' => [
                'required',
                'integer',
                'exists:station,id_station',
                Rule::unique('numero_station')
                    ->where('compagne_id', $request->compagne)
                    ->ignore($request->input('id_numero_stations'), 'id_numero_stations'),
            ],
            'numero_station' => [
                'required',
                'integer',
                Rule::unique('numero_station')
                    ->where(function ($query) use ($request) {
                        return $query->where('compagne_id', $request->compagne_id);
                    })
                    ->ignore($request->input('id_numero_station'), 'id_numero_station'),
            ],
        ], [
            'compagne_id.required' => 'Ce champ est obligatoire.',
            'station_id.required' => 'Ce champ est obligatoire.',
            'station_id.unique' => 'Cette station est déjà utilisée pour cette compagne.',
            'numero_station.required' => 'Ce champ est obligatoire.',
            'numero_station.unique' => 'Ce numéro de station est déjà utilisé pour cette compagne.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            $id = $request->input('id_numero_station');
            $data = $request->only(['compagne_id', 'station_id','numero_station']);
            $numeroStation = NumeroStation::updateNumeroStation($id, $data);
            return response()->json(['status' => 'success', 'message' => 'Numéro station mis à jour avec succès!', 'numeroStation' => $numeroStation]);
        } catch (\Exception $e) {
            Log::error('Error updating station: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
