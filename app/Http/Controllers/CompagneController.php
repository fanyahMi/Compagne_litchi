<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CompagneController extends Controller
{

    public function compagne(){
        return view('station.Compagne');
    }

    public function getCompagne() {
        $compagne = DB::table('compagne')->get();

        return response()->json($compagne);
    }

    public function addAnnee_compagne(Request $request){
        $validator = Validator::make($request->all(),[
            'annee' => 'required|numeric|min:1800',
            'debut' => 'required|date',
            'fin' => ['required', 'date', 'after:debut'],
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'debut.required' => 'Le mois de départ est requis.',
            'debut.date_format' => 'Le mois de départ doit être au format AAAA-MM.',
            'fin.required' => 'Le mois de fin est requis.',
            'fin.date_format' => 'Le mois de fin doit être une date',
            'fin.after' => 'Le mois de fin doit être après la date de début.',
        ]);

        $etat = Carbon::now()->lessThanOrEqualTo($validatedData['fin']) ? 1 : 0;

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            DB::table('compagne')->insert([
                'annee' => $validatedData['annee'],
                'debut' => $validatedData['debut'],
                'fin' => $validatedData['fin'],
                'etat' => $etat
            ]);
            return response()->json([
                'message' => 'Compagne ajouté avec succès',
                       ], 200);

        } catch (Exception $e) {
           return response()->json(['error' => 'Erreur lors de l\'ajout deu compagne: ' . $e->getMessage()], 400);
        }
    }
}
