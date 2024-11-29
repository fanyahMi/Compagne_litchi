<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Station;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Log;

class StationController extends Controller
{
    public function index(){
        return view('station.Station');
    }
/*
    public function getStation() {
        $station = Station::all();

        return response()->json($station);
    }
*/
    public function getStation(Request $request) {
        $name = $request->input('name');
        $perPage = $request->input('per_page', 2); // Par défaut, 10 éléments par page

        $station = Station::getStationTableau($perPage, $name);

        if ($station === ' ') {
            return response()->json(['message' => 'Les champs sont vides ou null.'], 400);
        }

        return response()->json($station);
    }

    public function addStation(Request $request){
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'nif_stat' => [
                'required',
                'size:13',
                'regex:/^[A-Za-z0-9]+$/',
                Rule::unique('station')
            ]
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'nif_stat.required' => 'Le NIF est obligatoire.',
            'nif_stat.size' => 'Le NIF doit contenir exactement 13 caractères',
            'nif_stat.regex' => 'Le NIF ne doit contenir que des lettres et des chiffres',
            'nif_stat.unique' => 'Le NIF existe déjà dans la base de données.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            Station::create([
                    'station' => $validatedData['nom'],
                    'nif_stat' => $validatedData['nif_stat']
                ]);
            return response()->json([
                'message' => 'Station ajouté avec succès',
                       ], 200);

        } catch (Exception $e) {
           return response()->json(['error' => 'Erreur lors de l\'ajout de station: ' . $e->getMessage()], 400);
        }
    }

    public function getById($id){
        try {
            $station = Station::getStationById($id);
            return response()->json($station);
        } catch (\Exception $e) {
            Log::error('Error fetching station: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }


    public function update(Request $request){
        $validatedData = $request->validate([
            'id_station' => 'required|integer|exists:station,id_station',
            'nom' => 'required|string|max:255',
            'nif_stat' => [
                'required',
                'size:13',
                'regex:/^[A-Za-z0-9]+$/',
                Rule::unique('station')->ignore($request->input('id_station'), 'id_station')
            ]
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'nif_stat.required' => 'Le NIF est obligatoire.',
            'nif_stat.size' => 'Le NIF doit contenir exactement 13 caractères',
            'nif_stat.regex' => 'Le NIF ne doit contenir que des lettres et des chiffres',
            'nif_stat.unique' => 'Le NIF existe déjà dans la base de données.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            $id = $request->input('id_station');
            $data = $request->only(['nom', 'nif_stat']);
            $station = Station::updateStation($id, $data);
            return response()->json(['status' => 'success', 'message' => 'Station mis à jour avec succès!', 'station' => $station]);
        } catch (\Exception $e) {
            Log::error('Error updating station: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function quotas(){

        $stations = DB::table('v_station_numero_compagne')
                        ->select('id_numero_station','numero_station','annee', 'station')
                        ->where('etat', '!=', '0')
                        ->get();
        $navires = DB::table('navire')->select('id_navire', 'navire')->get();
        $compagnes = DB::table('compagne')->get();

        return view('station.Quotas', compact('navires','stations','compagnes'));
    }

    public function getQuotas() {
        $quotas = DB::table('v_quotas_station')->get();

        return response()->json($quotas);
    }

    public function addQuotas(Request $request){
        $validatedData = $request->validate([
            'navire_id' => 'required|integer|exists:navire,id_navire',
            'numero_station_id' => 'required|integer|exists:numero_station,id_numero_station',
            'quotas' => 'required|integer|min:1',
        ], [
            'navire_id.required' => 'Le champ navire est obligatoire.',
            'navire_id.integer' => 'Le champ navire doit être un nombre entier.',
            'navire_id.exists' => 'Le navire sélectionné est invalide.',

            'numero_station_id.required' => 'Le champ numéro de station est obligatoire.',
            'numero_station_id.integer' => 'Le champ numéro de station doit être un nombre entier.',
            'numero_station_id.exists' => 'Le numéro de station sélectionné est invalide.',

            'quotas.required' => 'Le champ quotas est obligatoire.',
            'quotas.integer' => 'Le champ quotas doit être un nombre entier.',
            'quotas.min' => 'Le nombre de quotas doit être au moins 1.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            DB::table('quotas')->insert([
                'navire_id' => $validatedData['navire_id'],
                'numero_station_id' => $validatedData['numero_station_id'],
                'quotas' => $validatedData['quotas'],
            ]);
            return response()->json([
                'message' => 'Quotas ajouté avec succès',
                       ], 200);

        } catch (Exception $e) {
           return response()->json(['error' => 'Erreur lors de l\'ajout du quotas : ' . $e->getMessage()], 400);
        }
    }

    public function getQuotasById($id){
        $quotas = DB::table('quotas')->where('id_quotas', $id)->first();

        if ($quotas) {
            return response()->json($quotas);
        } else {
            return response()->json(['message' => 'Quotas not found'], 404);
        }
    }

    public function updateQuotas(Request $request){
        $validator = Validator::make($request->all(), [
            'id_quotas' => 'required|integer|exists:quotas,id_quotas',
            'navire_id' => 'required|integer|exists:navire,id_navire',
            'numero_station_id' => 'required|integer|exists:numero_station,id_numero_station',
            'quotas' => 'required|integer|min:1',
        ], [
            'navire_id.required' => 'Le champ navire est obligatoire.',
            'navire_id.integer' => 'Le champ navire doit être un nombre entier.',
            'navire_id.exists' => 'Le navire sélectionné est invalide.',
            'numero_station_id.required' => 'Le champ numéro de station est obligatoire.',
            'numero_station_id.integer' => 'Le champ numéro de station doit être un nombre entier.',
            'numero_station_id.exists' => 'Le numéro de station sélectionné est invalide.',
            'quotas.required' => 'Le champ quotas est obligatoire.',
            'quotas.integer' => 'Le champ quotas doit être un nombre entier.',
            'quotas.min' => 'Le nombre de quotas doit être au moins 1.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            $id = $request->input('id_quotas');
            $data = $request->only(['navire_id', 'numero_station_id','quotas']);
            $quotas = Station::updateQuotas($id, $data);
            return response()->json(['status' => true, 'message' => 'Quotas mis à jour avec succès!', 'quotas' => $quotas]);
        } catch (\Exception $e) {
            Log::error('Error updating station: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

}
