<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Campagne;
use Log;

class CompagneController extends Controller
{

    public function compagne(){
        return view('station.Compagne');
    }

    public function getCompagne() {
        $compagne = DB::table('compagne')
                    ->orderBy('annee','desc')
                    ->get();
        return response()->json($compagne);
    }
    public function getCompagneEnCours()
    {
        $compagne = DB::table('compagne')
                    ->where('etat', 1)
                    ->first();
        return response()->json($compagne);
    }


    public function addAnnee_compagne(Request $request){
        $validator = Validator::make($request->all(), [
            'annee' => 'required|numeric|min:1800',
            'debut' => 'required|date',
            'fin' => ['nullable', 'date', 'after:debut'],
        ], [
            'annee.required' => 'L\'année est obligatoire.',
            'annee.numeric' => 'L\'année doit être un nombre.',
            'annee.min' => 'L\'année doit être supérieure ou égale à 1800.',
            'debut.required' => 'La date de début est obligatoire.',
            'debut.date' => 'La date de début doit être une date valide.',
            'fin.date' => 'La date de fin doit être une date valide.',
            'fin.after' => 'La date de fin doit être après la date de début.',
        ]);

        $etat = $request['fin'] ? (Carbon::now()->lessThanOrEqualTo($request['fin']) ? 1 : 0) : 1;

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            DB::table('compagne')->insert([
                'annee' => $request['annee'],
                'debut' => $request['debut'],
                'fin' => $request['fin'] ?? null,
                'etat' => $etat
            ]);
            return response()->json([
                'message' => 'Compagne ajouté avec succès',
                       ], 200);

        } catch (Exception $e) {
           return response()->json(['error' => 'Erreur lors de l\'ajout deu compagne: ' . $e->getMessage()], 400);
        }
    }

    public function terminer($id){
        try {

            $compagnes = Campagne::findOrFail($id);
            $compagnes->update([
                'etat' => 0,
                'fin' => now(),
            ]);

            return response()->json(['status' => true, 'message' => 'Compagne mis à jour avec succès!', 'compagnes' => $compagnes]);
        } catch (\Exception $e) {
            Log::error('Error updating : ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }

    }


}
