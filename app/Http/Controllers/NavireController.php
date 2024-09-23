<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Navire;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Log;

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
        $validatedData = $request->validate([
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


        try {

            Navire::create([
                'navire' => $validatedData['nom'],
                'nb_compartiment' => $validatedData['nb_compartiment'],
                'quantite_max' => $validatedData['quantite_max'],
                'type_navire_id' => $validatedData['type_navire']
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
        $validatedData = $request->validate([
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
}
