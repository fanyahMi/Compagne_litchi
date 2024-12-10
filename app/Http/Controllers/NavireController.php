<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Navire;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class NavireController extends Controller
{
    public function index(){
        $type_navire = DB::table('type_navire')->select('id_type_navire', 'type_navire')->get();

        return view('navire.List_navire', compact('type_navire'));
    }

    public function getNavire(Request $request) {

        $nom = $request->input('navire');
        $type = $request->input('type');
        $capacite = $request->input('capacite');
        $condition = $request->input('condition');
        $perPage = $request->input('per_page', 10); // Par défaut, 10 éléments par page

        $navires = Navire::getNavireTableau($perPage, $nom, $type, $capacite ,$condition);

        if ($navires === ' ') {
            return response()->json(['message' => 'Les champs sont vides ou null.'], 400);
        }

        return response()->json($navires);
    }

    public function addnavire(Request $request) {

        $validator = Validator::make($request->all(),[
            'nom' => 'required|string|max:255',
            'nb_compartiment' => 'required|numeric',
            'quantite_max' => 'required|numeric',
            'type_navire' => 'required|integer'
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'nb_compartiment.required' => 'Nombre de compatiment requis.',
            'quantite_max.required' => 'Capacite du navire obligatoire.',
            'type_navire.required' => 'Le type de navire est obligatoire.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {

            Navire::create([
                'navire' =>  $request->input('nom'),
                'nb_compartiment' =>  $request->input('nb_compartiment'),
                'quantite_max' =>  $request->input('quantite_max'),
                'type_navire_id' =>  $request->input('type_navire')
            ]);
            return response()->json([
                'message' => 'Navire ajouté avec succès',
                       ], 200);

        } catch (Exception $e) {
           return response()->json(['error' => 'Erreur lors de l\'ajout du navire: ' . $e->getMessage()], 400);
        }
    }

    public function getById($id){
        try {
            $navire = Navire::findOrFail($id);
            return response()->json($navire);
        } catch (\Exception $e) {
            Log::error('Error fetching navire: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'nom' => 'required|string|max:255',
            'nb_compartiment' => 'required|numeric',
            'quantite_max' => 'required|numeric',
            'type_navire' => 'required|integer'
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'nb_compartiment.required' => 'Nombre de compatiment requis.',
            'quantite_max.required' => 'Capacite du navire obligatoire.',
            'type_navire.required' => 'Le type de navire est obligatoire.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            $id = $request->input('id_navire');
            $data = $request->only(['nom', 'nb_compartiment', 'quantite_max', 'type_navire']);
            $navire = Navire::updateNavire($id, $data);

            return response()->json(['status' => 'success', 'message' => 'Navire mis à jour avec succès!', 'navire' => $navire]);
        } catch (\Exception $e) {
            Log::error('Error updating agent: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function mouvement(){
        $compagnes = DB::table('compagne')
                    ->select('id_compagne', 'annee')
                    ->where('etat', '!=', 0)
                    ->get();
        $navires = Navire::all();
        return view('navire.Mouvement', compact('compagnes','navires'));
    }

    public function addmouvementnavire(Request $request) {

        $validator = Validator::make($request->all(),[
            'compagne_id' => 'required|numeric',
            'navire_id' => 'required|numeric',
            'date_arrive' => 'required|date',
            'date_depart' => 'nullable|date|after_or_equal:date_arrive'
        ], [
            'compagne_id.required' => 'L\'identifiant de la campagne est obligatoire.',
            'compagne_id.numeric' => 'L\'identifiant de la campagne doit être un nombre.',

            'navire_id.required' => 'L\'identifiant du navire est obligatoire.',
            'navire_id.numeric' => 'L\'identifiant du navire doit être un nombre.',

            'date_arrive.required' => 'La date d’arrivée est obligatoire.',
            'date_arrive.date' => 'La date d’arrivée doit être une date valide.',

            'date_depart.date' => 'La date de départ doit être une date valide.',
            'date_depart.after_or_equal' => 'La date de départ doit être après ou égale à la date d’arrivée.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {

            DB::table('mouvement_navire')->insert([
                'compagne_id' =>  $request->input('compagne_id'),
                'date_arriver' =>  $request->input('date_arrive'),
                'date_depart' =>  $request->input('date_depart',null),
                'navire_id' =>  $request->input('navire_id')
            ]);
            return response()->json([
                'message' => 'Navire ajouté avec succès',
                       ], 200);

        } catch (Exception $e) {
           return response()->json(['error' => 'Erreur lors de l\'ajout du navire: ' . $e->getMessage()], 400);
        }
    }

    public function getmouvementnavire(Request $request) {
        $compagne = $request->input('compagne');
        $navire = $request->input('navire');
        $date_arriver = $request->input('date_arriver');
        $date_depart = $request->input('date_depart');
        $perPage = $request->input('per_page', 10);

        $mouvement = Navire::getmouvementTableau($perPage,$compagne, $navire, $date_arriver, $date_depart);

        if ($mouvement === ' ') {
            return response()->json(['message' => 'Les champs sont vides ou null.'], 400);
        }

        return response()->json($mouvement);
    }

    public function getmouvementId($id){
        try {
            $mouvements = DB::table('mouvement_navire')->where('id_mouvement_navire', $id)->first();

            return response()->json($mouvements);
        } catch (Exception $e) {
            Log::error('Error fetching navire: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    public function updateMouvement(Request $request){
        //Log::debug($request->all());
        $validator = Validator::make($request->all(),[
            'compagne_id-modal' => 'required|numeric',
            'navire_id-modal' => 'required|numeric',
            'date_arrive-modal' => 'required|date',
            'date_depart-modal' => 'nullable|date|after_or_equal:date_arrive-modal'
        ], [
            'compagne_id-modal.required' => 'L\'identifiant de la campagne est obligatoire.',
            'compagne_id-modal.numeric' => 'L\'identifiant de la campagne doit être un nombre.',

            'navire_id-modal.required' => 'L\'identifiant du navire est obligatoire.',
            'navire_id-modal.numeric' => 'L\'identifiant du navire doit être un nombre.',

            'date_arrive-modal.required' => 'La date d’arrivée est obligatoire.',
            'date_arrive-modal.date' => 'La date d’arrivée doit être une date valide.',

            'date_depart-modal.date' => 'La date de départ doit être une date valide.',
            'date_depart-modal.after_or_equal' => 'La date de départ doit être après ou égale à la date d’arrivée.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }

        try {
            $id = $request->input('id_mouvement_navire');
            $data = array(
                'date_arrive' => $request->input('date_arrive-modal'),
                'compagne_id' => $request->input('compagne_id-modal'),
                'navire_id' => $request->input('navire_id-modal'),
                'date_depart' => $request->input('date_depart-modal'),
            );
            $mouvement = Navire::updateMouvement($id, $data);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Erreur de modification : ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getNaviresEnPlace() {
        $navires = DB::table('v_mouvement_navire')
            ->whereNull('date_depart')
            ->get();

        return response()->json($navires);
    }
    public function getDetailNavireApi( $idNavire)
    {
        try {
            $navire = Navire::where('id_navire', $idNavire)
                                      ->firstOrFail();
            return response()->json($navire);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Navire non trouvé ou déja parti'], 404);
        }
    }
    public function getQuatiteCalesApi( $idNavire)
    {
        try {
            $compagne = DB::table('compagne')
                    ->where('etat', 1)
                    ->first();
            $navire = DB::table('v_quantite_cales')
            ->where('id_navire', '=', $idNavire)
            ->where('id_compagne', '=', $compagne->id_compagne)
            ->get();
            return response()->json($navire);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Navire non trouvé ou déja parti'], 404);
        }
    }




}

///
