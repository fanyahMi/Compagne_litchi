<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NumeroStation extends Model
{
    protected $table = 'numero_station';

    protected $fillable = [
        'compagne_id',
        'station_id',
        'numero_station'
    ];

    public $timestamps = false;
    protected $primaryKey = "id_numero_station";
    public $incrementing = true;

    public static function getListeNumeroStation($perPage = 10, $compagne = null) {
        $query = DB::table('v_station_numero_compagne')
                    ->orderBy('id_compagne','desc');

        if (!empty($compagne)) {
            $query->where('id_compagne', $compagne );
        }

        if($perPage == -1){
            return $query->get();
        }
        $numero_station = $query->paginate($perPage);

        return $numero_station;
    }

    public static function ajouteNumeroStation(array $data){
        try {
            DB::beginTransaction();
            self::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Erreur lors de l'insertion des données : " . $e->getMessage());
        }
    }

    public static function findNumeroStation($id) {
        $result = DB::table('v_station_numero_compagne')
                            ->where('id_numero_station', $id)
                            ->first();

        if (!$result) {
            throw new ModelNotFoundException("Aucun numéro n'est atribué à cette station.");
        }

        // Return the found result
        return $result;
    }

    public static function updateNumeroStation($id, array $data)    {
        try {
            $numero = NumeroStation::findOrFail($id);
            $numero->update([
                'compagne_id' => $data['compagne_id'],
                'station_id' => $data['station_id'],
                'numero_station' => $data['numero_station'],
            ]);
            return $station;
        } catch (\Exception $e) {
            Log::error('Error updating numero station: ' . $e->getMessage());
            throw new \Exception('Erreur lors de la mise à jour du numéro de station .');
        }
    }

}

