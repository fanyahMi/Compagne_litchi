<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompagneController extends Controller
{

    public function compagne(){
        return view('station.Compagne');
    }

    public function addAnnee_compagne(){
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
}
