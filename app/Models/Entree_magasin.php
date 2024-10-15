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
            $entreeMagasin = self::create($data);
            DB::commit();
            return $entreeMagasin;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Erreur lors de l'insertion des données : " . $e->getMessage());
        }
    }


    public static function modifierEntrer(array $data, string $base64File = null){
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
                Storage::disk('public')->delete($data['encien']);
                Storage::disk('public')->put($path, $fileData);
            } else {
                throw new \Exception("Le fichier doit être au format PDF.");
            }
        }else{
            $path = $data['encien'];
        }


        try {
            DB::beginTransaction();

            self::where('id_entree_magasin', $data['id_entree'])
            ->update([
                'quantite_palette' => $data['quantite_palette'],
                'station_id' => $data['station_id'],
                'navire_id' => $data['navire_id'],
                'bon_livraison' => $data['bon_livraison'],
                'numero_camion' => $data['numero_camion'],
                'chauffeur' => $data['chauffeur'],
                'path_bon_livraison' => $path,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Erreur lors de l'insertion des données : " . $e->getMessage());
        }
    }
    public  static function getCamionMagasin(){
        $data = DB::table('v_mouvement_magasin')
                ->select('navire', 'station', 'numero_camion', 'chauffeur', 'date_entrant', 'date_sortie')
                ->get();
                return $data;
    }

    public static function getCamionNonSortie(){
        $data = DB::table('v_mouvement_magasin')
            ->select('numero_camion', 'id_entree_magasin')
            ->whereNull('id_sortant_magasin')
            ->get();
        return $data;
    }
    public static function getQuantiteEntrant($idEntreMagasin){
        $data = DB::table('v_mouvement_magasin')
            ->select('quantite_palette', 'id_entree_magasin')
            ->where('id_entree_magasin', $idEntreMagasin)
            ->first();
        return $data;
    }

    public static function getStationById($id){
        try {
            return Entree_magasin::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error fetching entree magasin: ' . $e->getMessage());
            throw new \Exception('Entrée en magasin non trouvé.');
        }
    }

}
