<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recherche extends Model
{
    protected $table = "exemple";
    protected $fillable = [
        'texte_texte',
        'texte_varchar',
        'nombre_entier',
        'nombre_decimal',
        'nombre_double',
        'date_col',
        'heure_col',
        'timestamp_col',
        'bool_col',
    ];

    public $timestamps = false;
    protected $primaryKey = "id";
    public $incrementing = false;
}
