<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Log;

class Station extends Model
{
    protected $table = "station";
    protected $fillable = [
        'station',
        'nif_stat'
    ];

    public $timestamps = false;
    protected $primaryKey = "id_station";
    public $incrementing = true;

    public static function getStationById($id){
        try {
            return Station::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error fetching station: ' . $e->getMessage());
            throw new \Exception('Station non trouvé.');
        }
    }

    public static function updateStation($id, array $data)
    {
        try {
            $station = Station::findOrFail($id);
            $station->update([
                'station' => $data['nom'],
                'nif_stat' => $data['nif_stat'],
            ]);
            return $station;
        } catch (\Exception $e) {
            Log::error('Error updating station: ' . $e->getMessage());
            throw new \Exception('Erreur lors de la mise à jour de la station.');
        }
    }

    public static function updateQuotas($id, array $data){
        try {
            $updated = DB::table('quotas')
                ->where('id_quotas', $id)
                ->update([
                    'navire_id' => $data['navire_id'],
                    'numero_station_id' => $data['numero_station_id'],
                    'quotas' => $data['quotas'],
                ]);

            if ($updated) {
                return DB::table('quotas')->where('id_quotas', $id)->first();
            } else {
                throw new \Exception('Record not found or update failed.');
            }
        } catch (\Exception $e) {
            Log::error('Error updating quotas: ' . $e->getMessage());
            throw new \Exception('Erreur lors de la mise à jour du quotas.');
        }
    }

}
