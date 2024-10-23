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

    public static function getListeNumeroStationCompagneEncoure() {
        $data = DB::table('v_station_numero_compagne')
                    ->get();
        return $data;
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
        // Query the table using the query builder
        $result = DB::table('v_station_numero_compagne')
                            ->where('id_numero_station', $id)
                            ->first();

        // If no result is found, throw an exception
        if (!$result) {
            throw new ModelNotFoundException("Aucun numéro n'est atribué à cette station.");
        }

        // Return the found result
        return $result;
    }
}

