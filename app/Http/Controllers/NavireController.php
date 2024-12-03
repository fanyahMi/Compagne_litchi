<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Navire;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class NavireController extends Controller
{
    public function index(){
        $type_navire = DB::table('type_navire')->select('id_type_navire', 'type_navire')->get();

        return view('navire.List_navire', compact('type_navire'));
    }

    public function getNavire() {
        $navire = Navire::all();

        return response()->json($navire);
    }

    public function addnavire(Request $request) {
        $validator = Validator::make($request->all() ,[
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
        $validator = Validator::make([
            $request->all(),
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

    public function getNaviresEnPlace()
    {
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
            $navire = DB::table('v_quantite_cales')
            ->where('id_navire', '=', $idNavire)
            ->get();
            return response()->json($navire);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Navire non trouvé ou déja parti'], 404);
        }
    }




}

///
