<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Campagne;
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
        $perPage = $request->input('per_page', 10);

        $station = Station::getStationTableau($perPage, $name);

        if ($station === ' ') {
            return response()->json(['message' => 'Les champs sont vides ou null.'], 400);
        }

        return response()->json($station);
    }

    public function addStation(Request $request){
        $validator = Validator::make($request->all(),[
            'nom' => 'required|string|max:255',
            'nif_stat' => [
                'required',
                'size:13',
                'regex:/^[A-Za-z0-9]+$/',
                Rule::unique('station')
            ]
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'nif_stat.required' => 'Le NIF/STAT est obligatoire.',
            'nif_stat.size' => 'Le NIF/STAT doit contenir exactement 13 caractères',
            'nif_stat.regex' => 'Le NIF/STAT ne doit contenir que des lettres et des chiffres',
            'nif_stat.unique' => 'Le NIF/STAT existe déjà dans la base de données.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            Station::create([
                    'station' => $request['nom'],
                    'nif_stat' => $request['nif_stat']
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
        $validator = Validator::make([
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

        $normal_stations =  Station::all();

        return view('station.Quotas', compact('navires','stations','compagnes', 'normal_stations'));
    }

    public function getQuotas(Request $request) {
        $navire = $request->input('navire');
        $campagne = $request->input('campagne');
        $station = $request->input('station');
        $perPage = $request->input('per_page', 10);

        $query  = DB::table('v_quotas_station')
                    ->orderBy('id_compagne','desc');
        if(!empty($campagne)){
            $query->where('id_compagne', $campagne );
        }
        if(!empty($navire)){
            $query->where('id_navire', $navire );
        }
        if(!empty($station)){
            $query->where('id_station', $station );
        }

        $quotas = $query->paginate($perPage);
        return response()->json($quotas);
    }

    public function addQuotas(Request $request){
        $validator = Validator::make($request->all(),[
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
                'navire_id' => $request['navire_id'],
                'numero_station_id' => $request['numero_station_id'],
                'quotas' => $request['quotas'],
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

    public function updateQuotas(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'id_quotas' => 'required|integer|exists:quotas,id_quotas',
            'navire_id' => 'required|integer|exists:navire,id_navire',
            'numero_station_id' => 'required|integer|exists:numero_station,id_numero_station',
            'quotas' => 'required|numeric|min:1',
        ], [
            'navire_id.required' => 'Le champ navire est obligatoire.',
            'navire_id.integer' => 'Le champ navire doit être un nombre entier.',
            'navire_id.exists' => 'Le navire sélectionné est invalide.',
            'numero_station_id.required' => 'Le champ numéro de station est obligatoire.',
            'numero_station_id.integer' => 'Le champ numéro de station doit être un nombre entier.',
            'numero_station_id.exists' => 'Le numéro de station sélectionné est invalide.',
            'quotas.required' => 'Le champ quotas est obligatoire.',
            'quotas.numeric' => 'Le quota doit être un nombre.',
            'quotas.min' => 'Le nombre de quotas doit être au moins 1.',
        ]);

        // Vérifier si la validation échoue
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Retour des erreurs spécifiques
        }

        try {
            
            // Logique pour mettre à jour les quotas
            $id = $request->input('id_quotas');
            $data = $request->only(['navire_id', 'numero_station_id', 'quotas']);
            $quotas = Station::updateQuotas($id, $data);

            return response()->json([
                'status' => true,
                'message' => 'Quotas mis à jour avec succès!',
                'quotas' => $quotas
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating quotas: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour des quotas.'
            ], 500);
        }
    }


    public function getNumeroStationCampagneEnCours(){
        $compagne = DB::table('v_station_numero_compagne')
                    ->where('etat', 1)
                    ->get();
        return response()->json($compagne);
    }

    public function historiqueQuotasStation(Request $request){
        $validator = Validator::make($request->all(),
        [
            'id_station' => 'required|integer|exists:station,id_station'
        ], [
            'id_station.required' => 'Le champ id_station est obligatoire.',
            'id_station.integer' => 'Le champ id_station doit être un nombre entier.',
            'id_station.exists' => 'Le station sélectionné est invalide.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $id_station = $request->input('id_station');
        $station = Station::where('id_station', $id_station)->first();
        $campagnes = Campagne::all();
        return view('station.HistoriqueQuotas', compact('station' , 'campagnes'));
    }

    public function getQuotasStationCampgane(Request $request){
        $idStation = $request->input('id_station');
        $idCampagne = $request->input('id_campagne');
        $perPage = $request->input('per_page', 10);
        $query = DB::table('v_quotas_station')
                    ->where('id_station', $idStation);
        if (!empty($idCampagne)) {
            $query->where('id_compagne', $idCampagne);
        }
        $data = $query->paginate($perPage);
        return response()->json($data);
    }


    public function getResteQuantitePaletteStation($idNumeroStation, $idNavire){
        try {
            $restePalette = DB::table('v_reste_palette_station')
                        ->select('reste')
                        ->where('id_numero_station', $idNumeroStation)
                        ->where('id_navire', $idNavire)
                        ->first();
            return response()->json($restePalette);
        } catch (Exception $e) {
            Log::error('Error updating station: ' . $e->getMessage());
            $data = array(
                'num' =>$idNumeroStation,
                'nav' => $idNavire
            );
            return response()->json($data);
        }
    }

}
