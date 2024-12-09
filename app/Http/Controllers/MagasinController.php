<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use App\Models\Entree_magasin;
use App\Models\Sorti_magasin;
use App\Models\NumeroStation;
use App\Models\Station;
use App\Models\Shift;
use Illuminate\Support\Facades\Validator;
use Log;
use Mpdf\Mpdf;

class MagasinController extends Controller
{
    public function index(){
        $normal_navires = DB::table('navire')
                    ->select('id_navire', 'navire','quantite_max')
                    ->get();
                    $navires = DB::table('v_mouvement_navire')
                    ->select('id_navire', 'navire', 'quantite_max')
                    ->whereNull('date_depart')  // Utilisation de whereNull pour vérifier si 'date_depart' est NULL
                    ->get();

                    $compagne = DB::table('compagne')
                    ->where('etat', 1)
                    ->first();
        $stations = NumeroStation::getListeNumeroStation(-1, $compagne->id_compagne);
        $compagnes = DB::table('compagne')->get();
        $normal_stations =  Station::all();
        $shifts = Shift::all();
        return view('magasin.Entree', compact('navires', 'stations', 'normal_navires' ,'compagnes' ,'normal_stations', 'shifts'));
    }

    public function listeCamion(Request $request)
    {
        $compagnes = DB::table('compagne')->get();
        $normal_stations =  Station::all();
        $shifts = Shift::all();

        return view('magasin.camion', compact( 'compagnes', 'normal_stations', 'shifts'));
    }


    public function insertEntrer(Request $request)
{
    // Validation des données d'entrée
    $validator = Validator::make($request->all(), [
        'numero_camion' => 'required|string|max:50',
        'bon_livraison' => 'required|string|max:50|unique:entree_magasin,bon_livraison',
        'chauffeur' => 'required|string|max:60',
        'quantite_palette' => 'required|integer|min:1',
        'numero_station_id' => 'required|integer|exists:numero_station,id_numero_station',
        'navire_id' => 'nullable|integer|exists:navire,id_navire',
        'fichier_base64' => 'nullable|string', // Ajout de la validation pour le fichier Base64
    ], [
        'numero_camion.required' => 'Le numéro du camion est obligatoire.',
        'bon_livraison.required' => 'Le bon de livraison est obligatoire.',
        'bon_livraison.unique' => 'Ce bon de livraison existe déjà.',
        'chauffeur.required' => 'Le nom du chauffeur est obligatoire.',
        'quantite_palette.required' => 'La quantité de palettes est obligatoire.',
        'quantite_palette.min' => 'La quantité de palettes doit être au moins de 1.',
        'numero_station_id.exists' => 'La station sélectionnée est invalide.',
        'navire_id.exists' => 'Le navire sélectionné est invalide.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $base64File = $request->input('fichier_base64');
        $agentId = session('agent.id');
        $entreeMagasin = Entree_magasin::ajouterEntrer($validator->validated(), $base64File, $agentId);

        return response()->json([
            'status' => true,
            'message' => 'Entrée ajoutée avec succès.',
            'data' => $entreeMagasin,
        ], 201);
    } catch (Exception $e) {
       return response()->json([
            'status' => false,
            'error' => 'Erreur lors de l\'insertion des données: ' . $e->getMessage()
        ], 500);
    }
}


    public function sortie(){
        $camion = DB::table('navire')
                    ->select('id_navire', 'navire','quantite_max')
                    ->get();


        return view('magasin.Sortie', compact('navires', 'stations'));
    }


    public function formSortie(){
        $camions = Entree_magasin::getCamionNonSortie();
        $compagnes = DB::table('compagne')->get();
        $normal_stations =  Station::all();
        $shifts = Shift::all();
        $normal_navires = DB::table('navire')
        ->select('id_navire', 'navire','quantite_max')
        ->get();
        return view('magasin.sortie', compact('camions', 'normal_navires' ,'compagnes' ,'normal_stations', 'shifts'));
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

    public function getEntree(Request $request) {
        $navire = $request->input('navire');
        $campagne = $request->input('campagne');
        $station = $request->input('station');
        $shift = $request->input('shift');
        $camion = $request->input('camion$camion');
        $bon_livraison = $request->input('bon_livraison');
        $debut = $request->input('debut');
        $fin = $request->input('fin');
        $perPage = $request->input('per_page', 2);

        $query = DB::table('v_mouvement_magasin')
            ->select('*')
                ->orderBy('date_entrant', 'desc');
                if(!empty($campagne)){
                    $query->where('id_compagne', $campagne );
                }
                if(!empty($navire)){
                    $query->where('navire_id', $navire );
                }
                if(!empty($station)){
                    $query->where('id_station', $station );
                }
                if(!empty($shift)){
                    $query->where('id_shift', $shift );
                }
                if(!empty($camion)){
                    $query->where('numero_camion', $camion );
                }
                if(!empty($bon_livraison)){
                    $query->where('bon_livraison', $bon_livraison );
                }
                if (!empty($debut) && !empty($fin)) {
                    $query->whereBetween('date_entrant', [$debut, $fin]);
                }
                $entree = $query->paginate($perPage);
        return response()->json($entree);
    }

    public function getSortie(Request $request) {
        $navire = $request->input('navire');
        $campagne = $request->input('campagne');
        $station = $request->input('station');
        $shift = $request->input('shift');
        $camion = $request->input('camion$camion');
        $debut = $request->input('debut');
        $fin = $request->input('fin');
        $typeShift = $request->input('type_shift');
        $typeDate = $request->input('type_date');
        $mouvement = $request->input('mouvement');
        $perPage = $request->input('per_page', 2);
        if((int)$mouvement == 1){
            $query = DB::table('v_mouvement_magasin')
                    ->select('*');
        }else{
            $query = DB::table('v_mouvement_magasin')
            ->select('*')
            ->whereNotNull('quantite_sortie')
            ->whereNotNull('date_sortie');
        }
                    if(!empty($campagne)){
                        $query->where('id_compagne', $campagne );
                    }
                    if(!empty($navire)){
                        $query->where('navire_id', $navire );
                    }
                    if(!empty($station)){
                        $query->where('id_station', $station );
                    }
                    if(!empty($shift)){
                        if((int)  $typeShift == 1){
                            $query->where('id_shift', $shift );
                        }else{
                            $query->where('id_shift_sortie', $shift );
                        }
                    }
                    if(!empty($camion)){

                        $query->where('numero_camion', $camion );
                    }

                    if (!empty($debut) && !empty($fin)) {
                        if((int)  $typeDate == 1){
                            $query->whereBetween('date_entrant', [$debut, $fin]);
                        }else{
                            $query->whereBetween('date_sortie', [$debut, $fin]);
                        }

                    }
                    $sortie = $query->paginate($perPage);

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


    public function modifierEntrer(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'numero_camion' => 'required|string|max:50',
            'encien' => 'nullable|string',  // "encien" doit être nullable et de type chaîne
            'id_entree' => 'required|integer', // Ajout d'une validation pour 'id_entree'
            'bon_livraison' => 'required|string|max:50',
            'chauffeur' => 'required|string|max:60',
            'quantite_palette' => 'required|integer|min:1',
            'numero_station_id' => 'required|integer|exists:numero_station,id_numero_station',
            'navire_id' => 'nullable|integer|exists:navire,id_navire',  // 'navire_id' peut être nul
            'fichier_base64' => 'nullable|string',  // Ajout de la validation pour le fichier base64 (s'il existe)
        ], [
            'numero_camion.required' => 'Le numéro du camion est obligatoire.',
            'bon_livraison.required' => 'Le bon de livraison est obligatoire.',
            'chauffeur.required' => 'Le nom du chauffeur est obligatoire.',
            'quantite_palette.required' => 'La quantité de palettes est obligatoire.',
        ]);

        // Vérification si la validation échoue
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }

        try {
            // Récupération des données
            $base64File = $request->input('fichier_base64');
            $num = $request->input('numero_camion');
            $id = session('agent.id');
            $validatedData = $validator->validated(); // Utilisation des données validées

            // Appel de la méthode pour mettre à jour l'entrée
            Entree_magasin::modifierEntrer($validatedData, $base64File);

            return response()->json([
                'message' => "Entrée modifiée avec succès pour le camion : $num",
            ], 200);
        } catch (Exception $e) {
            // Gestion des erreurs
            return response()->json([
                'error' => 'Erreur lors de l\'insertion des données: ' . $e->getMessage()
            ], 400);
        }
    }

    public function telechergerBonLivraison($id){
        $entree = Entree_magasin::find($id);

        if (!$entree || !$entree->path_bon_livraison) {
            return response()->json(['error' => 'Fichier non trouvé ou accès non autorisé.'], 404);
        }

        $filePath = storage_path('app/public/' . $entree->path_bon_livraison);

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Fichier non trouvé.'], 404);
        }

        return response()->file($filePath);

    }


}

