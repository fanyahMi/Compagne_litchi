<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navire extends Model
{
    protected $table = "navire";
    protected $fillable = [
        'navire',
        'nb_compartiment',
        'quantite_max',
        'type_navire_id'
    ];

    public $timestamps = false;
    protected $primaryKey = "id_navire";
    public $incrementing = true;
}
