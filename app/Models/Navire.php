<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;
use Log;

class Navire extends Model
{
    protected $table = "navire";
    protected $fillable = [
        'navire',
        'nb_compartiment',
        'quantite_max',
        'type_navire_id'
    ];

    public $timestamps = false;
    protected $primaryKey = "id_navire";
    public $incrementing = true;

    public static function getNavireTableau($perPage = 10, $nom = null, $type = null, $capacite = null, $condition = 'greater') {
        // Initialiser la requête
        $query = Navire::orderBy('navire', 'asc');

        // Appliquer les filtres
        if (!empty($nom)) {
            $query->where('navire', 'like', '%' . $nom . '%');
        }

        if (!empty($type)) {
            $query->where('type_navire_id', $type);
        }

        if (!empty($capacite)) {
            if ($condition === 'greater') {
                $query->where('capacite', '>=', $capacite);
            } elseif ($condition === 'less') {
                $query->where('capacite', '<=', $capacite);
            }
        }

        // Récupérer les navires avec pagination
        return $query->paginate($perPage);
    }

    public static function updateNavire($id, array $data) {
        try {
            $navire = Navire::findOrFail($id);
            $navire->update([
                'navire' => $data['nom'],
                'nb_compartiment' => $data['nb_compartiment'],
                'quantite_max' => $data['quantite_max'],
                'type_navire_id' => $data['type_navire'],
            ]);
            Log::info($data);
            return $navire;
        } catch (\Exception $e) {
            Log::error('Error updating navire: ' . $e->getMessage());
            throw new \Exception('Erreur lors de la mise à jour du navire.');
        }
    }

    public static function getmouvementTableau($perPage = 10 ,$compagne = null, $navire = null, $date_arriver = null, $date_depart= null){
        // Initialiser la requête
        $query = DB::table('v_mouvement_navire')
                ->orderBy('date_arriver','desc');

        // Appliquer les filtres
        if (!empty($navire)) {
            $query->where('navire', 'like', '%' . $navire . '%');
        }

        if (!empty($compagne)) {
            $query->where('id_compagne', $compagne);
        }

        if (!empty($date_arriver)) {
            $query->where('date_arriver', $date_arriver);
        }

        if (!empty($date_depart)) {
            $query->where('date_depart', $date_depart);
        }

        $mouvements = $query->paginate($perPage);


        return $mouvements;
    }

    public static function updateMouvement($id, array $data) {
        try {
            // Vérifier si l'enregistrement existe
            $mouvement = DB::table('mouvement_navire')->where('id_mouvement_navire', $id)->first();
            if (!$mouvement) {
                throw new \Exception('Aucun mouvement trouvé avec cet identifiant.');
            }

            // Mettre à jour l'enregistrement
            $updated = DB::table('mouvement_navire')
                        ->where('id_mouvement_navire', $id)
                        ->update([
                            'compagne_id' => $data['compagne_id'],
                            'navire_id' => $data['navire_id'],
                            'date_arriver' => $data['date_arrive'],
                            'date_depart' => $data['date_depart'],
                        ]);
            // Vérifier si la mise à jour a modifié une ligne
            if ($updated) {
                // Récupérer et retourner les données mises à jour
                return $updated;
            } else {
                throw new \Exception('Aucune modification n\'a été apportée.');
            }
        } catch (\Exception $e) {
            Log::error('Erreur de modification : ' . $e->getMessage());
            throw new \Exception('Erreur lors de la mise à jour du mouvement : ' . $e->getMessage());
        }
    }


}
