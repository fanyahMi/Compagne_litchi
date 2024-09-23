<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Station;
use Illuminate\Validation\Rule;
use Exception;
use Log;

class StationController extends Controller
{
    public function index(){
        return view('station.Station');
    }

    public function getStation() {
        $station = Station::all();

        return response()->json($station);
    }

    public function addStation(Request $request) {
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

    public function getById($id)
    {
        try {
            $station = Station::getStationById($id);
            return response()->json($station);
        } catch (\Exception $e) {
            Log::error('Error fetching station: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }


    public function update(Request $request)
    {
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
}
