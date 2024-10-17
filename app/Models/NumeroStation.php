<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NumeroStation extends Model
{
    public static function getListeNumeroStationCompagneEncoure() {
        $data = DB::table('v_station_numero_compagne')
            ->select('id_station', 'station', 'annee', 'numero_station', 'id_numero_station')
            ->where('etat', '!=', 1)
            ->get();
        return $data;
    }

}

