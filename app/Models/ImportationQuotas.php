<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ImportationQuotas extends Model
{
    protected $table = "importation_quotas";
    protected $fillable = [
        'station',
        'compagne_id',
        'compagne_id',
        'navire',
        'quotas'
    ];

    public $timestamps = false;
    public $incrementing = true;

    public static function insertImportation($data){
        ImportationQuotas::insert($data);
        DB::statement("
            insert into numero_station (compagne_id, station_id, numero_station)
                select
                    i.compagne_id, s.id_station, i.numero_station
                from importation_quotas i
                left join station s on s.station = i.station
                group by i.compagne_id, s.id_station, i.numero_station");

                DB::statement("
                    insert into quotas(navire_id, numero_station_id, quotas)
                        SELECT
                            nav.id_navire,
                            num.id_numero_station,
                            imp.quotas
                        FROM
                            importation_quotas imp
                        LEFT JOIN
                            navire nav ON nav.navire = imp.navire
                        JOIN
                            station s ON s.station = imp.station
                        JOIN
                            numero_station num ON num.compagne_id = imp.compagne_id
                                        AND num.station_id = s.id_station  ");
                                        DB::statement("TRUNCATE TABLE importation_quotas");
                                    }


}
