<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use App\Models\Entree_magasin;
use Log;

class MagasinController extends Controller
{
    public function index(){
        $navires = DB::table('navire')
                    ->select('id_navire', 'navire','quantite_max')
                    ->get();
        $stations = DB::table('station')
                    ->select('id_station', 'station')
                    ->get();

        return view('magasin.Entree', compact('navires', 'stations'));
    }

    public function insertEntrer(Request $request){
        $validatedData = $request->validate([
            'numero_camion' => 'required|string|max:50',
            'bon_livraison' => 'required|string|max:50|unique:entree_magasin,bon_livraison',
            'chauffeur' => 'required|string|max:60',
            'quantite_palette' => 'required|integer|min:1',
            'station_id' => 'required|integer|exists:station,id_station',
            'navire_id' => 'nullable|integer|exists:navire,id_navire',
        ], [
            'numero_camion.required' => 'Le numéro du camion est obligatoire.',
            'bon_livraison.required' => 'Le bon de livraison est obligatoire.',
            'bon_livraison.unique' => 'Ce bon de livraison existe déjà.',
            'chauffeur.required' => 'Le nom du chauffeur est obligatoire.',
            'quantite_palette.required' => 'La quantité de palettes est obligatoire.',
        ]);

        try {
            $base64File = $request->input('fichier_base64');
            $id = session('agent.id');
            $entreeMagasin = Entree_magasin::ajouterEntrer($validatedData, $base64File, $id);

            return response()->json([
                'message' =>  $base64File,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de l\'insertion des données: ' . $e->getMessage()
            ], 400);
        }
    }

    public function sortie(){
        $camion = DB::table('navire')
                    ->select('id_navire', 'navire','quantite_max')
                    ->get();


        return view('magasin.Sortie', compact('navires', 'stations'));
    }

}

