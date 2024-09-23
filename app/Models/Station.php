<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
