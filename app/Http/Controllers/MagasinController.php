<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use App\Models\Entree_magasin;
use App\Models\Sorti_magasin;
use App\Models\NumeroStation;
use Log;

class MagasinController extends Controller
{
    public function index(){
        $navires = DB::table('navire')
                    ->select('id_navire', 'navire','quantite_max')
                    ->get();
        $stations = DB::table('v_station_numero_compagne')
                    ->select('*')
                    ->where('etat', '!=', 0)
                    ->get();

        return view('magasin.Entree', compact('navires', 'stations'));
    }


    public function insertEntrer(Request $request){
        $validatedData = $request->validate([
            'numero_camion' => 'required|string|max:50',
            'bon_livraison' => 'required|string|max:50|unique:entree_magasin,bon_livraison',
            'chauffeur' => 'required|string|max:60',
            'quantite_palette' => 'required|integer|min:1',
            'numero_station_id' => 'required|integer|exists:numero_station,id_numero_station',
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

    public function listeCamion(){
        $camions = Entree_magasin::getCamionMagasin();
        return view('magasin.camion', compact('camions'));
    }

    public function formSortie(){
        $camions = Entree_magasin::getCamionNonSortie();
        return view('magasin.sortie', compact('camions'));
    }

    public function ajouteSortie(Request $request)
    {
        $request->validate([
            'entree_magasin_id' => 'required|exists:entree_magasin,id_entree_magasin',
            'quantite_sortie' => 'required|integer|min:1',
        ]);
        $id = session('agent.id');

        $data = [
            'entree_magasin_id' => $request->entree_magasin_id,
            'quantite_sortie' => $request->quantite_sortie,
            'agent_id' => $id,
        ];
        Sorti_magasin::createSortie($data);
        return response()->json(['success' => 'Sortie enregistrée avec succès.']);
    }

    public function getQuantiteEntrant($idEntreMagasin){
        $data = Entree_Magasin::getQuantiteEntrant($idEntreMagasin);
        return response()->json($data);
    }

    public function getEntree() {
        $entree = Entree_magasin::getEntrerMagasin();

        return response()->json($entree);
    }

    public function getSortie() {
        $sortie = DB::table('v_mouvement_magasin')
                    ->select('matricule_sortant', 'quantite_sortie','date_sortie')
                    ->whereNotNull('quantite_sortie')
                    ->whereNotNull('date_sortie')
                    ->limit(5)
                    ->get();

        return response()->json($sortie);
    }

    public function getById($id){
        try {
            $entree = Entree_magasin::getEntrerMagasinByIdEntree($id);
            return response()->json($entree);
        } catch (\Exception $e) {
            Log::error('Error fetching entree: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }


    public function modifierEntrer(Request $request){

        $validatedData = $request->validate([
            'numero_camion' => 'required|string|max:50',
            'encien' => 'string',
            'id_entree' => 'required',
            'bon_livraison' => 'required|string|max:50',
            'chauffeur' => 'required|string|max:60',
            'quantite_palette' => 'required|integer|min:1',
            'numero_station_id' => 'required|integer|exists:numero_station,id_numero_station',
            'navire_id' => 'nullable|integer|exists:navire,id_navire',
        ], [
            'numero_camion.required' => 'Le numéro du camion est obligatoire.',
            'bon_livraison.required' => 'Le bon de livraison est obligatoire.',
            'chauffeur.required' => 'Le nom du chauffeur est obligatoire.',
            'quantite_palette.required' => 'La quantité de palettes est obligatoire.',
        ]);

        try {
            $base64File = $request->input('fichier_base64');
            $num =  $request->input('numero_camion');
            $id = session('agent.id');
            Entree_magasin::modifierEntrer($validatedData, $base64File);

            return response()->json([
                'message' =>   $num,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de l\'insertion des données: ' . $e->getMessage()
            ], 400);
        }
    }

}

