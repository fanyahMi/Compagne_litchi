<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $validatedData = $request->validate([
            'annee' => 'required|numeric|min:1800',
            'debut' => 'required|date_format:Y-m',
            'fin' => ['required', 'date_format:Y-m', 'after:mois_depart'],
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'debut.required' => 'Le mois de départ est requis.',
            'debut.date_format' => 'Le mois de départ doit être au format AAAA-MM.',
            'fin.required' => 'Le mois de fin est requis.',
            'fin.date_format' => 'Le mois de fin doit être au format AAAA-MM.',
            'fin.after' => 'Le mois de fin doit être après le mois de départ.',
        ]);

        $etat = Carbon::now()->lessThanOrEqualTo(Carbon::createFromFormat('Y-m', $validatedData['fin'])) ? 1 : 0;
        $debutDate = Carbon::createFromFormat('Y-m', $validatedData['debut'])->startOfMonth();
        $finDate = Carbon::createFromFormat('Y-m', $validatedData['fin'])->endOfMonth();


        try {
            DB::table('compagne')->insert([
                'annee' => $validatedData['annee'],
                'debut' => $debutDate,
                'fin' => $finDate,
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
