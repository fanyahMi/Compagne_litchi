<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Entree_magasin extends Model
{
    protected $table = 'entree_magasin';

    protected $fillable = [
        'numero_camion',
        'bon_livraison',
        'chauffeur',
        'quantite_palette',
        'date_entrant',
        'agent_id',
        'station_id',
        'magasin_id',
        'path_bon_livraison',
        'navire_id',
    ];

    public $timestamps = false;
    protected $primaryKey = "id_entree_magasin";
    public $incrementing = true;
    public static function ajouterEntrer(array $data, string $base64File = null, $id)
{
    $path = '';
    if ($base64File) {
        if (strpos($base64File, 'data:application/pdf;base64,') === 0) {
            $base64File = str_replace('data:application/pdf;base64,', '', $base64File);
            $fileData = base64_decode($base64File);
            if ($fileData === false) {
                throw new \Exception("Erreur lors du décodage du fichier.");
            }
            $filename = $data['bon_livraison'] . '_' . time() . '.pdf';
            $path = 'bon_livraison/' . $filename;
            Storage::disk('public')->put($path, $fileData);
        } else {
            throw new \Exception("Le fichier doit être au format PDF.");
        }
    }

    $data['path_bon_livraison'] = $path;
    $data['date_entrant'] = Carbon::now()->toDateString();
    $data['agent_id'] = $id;
    $data['magasin_id'] = 1;

    try {
        DB::beginTransaction();
        // Créez l'entrée dans la base de données
        $entreeMagasin = self::create($data);
        DB::commit();
        return $entreeMagasin; // Retourne l'entité créée
    } catch (\Exception $e) {
        DB::rollBack();
        // Ajoutez une exception personnalisée avec le message d'erreur
        throw new \Exception("Erreur lors de l'insertion des données : " . $e->getMessage());
    }
}

}
