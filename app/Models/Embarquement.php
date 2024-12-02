<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embarquement extends Model
{
    use HasFactory;

    protected $table = 'embarquement';

    protected $fillable = [
        'utilisateur_id',
        'shift_id',
        'numero_station_id',
        'navire_id',
        'numero_cal',
        'nombre_pallets'
    ];
    public $timestamps = false;
    protected $primaryKey = "id_embarquement";
    public $incrementing = true;
}
