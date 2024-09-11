<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
