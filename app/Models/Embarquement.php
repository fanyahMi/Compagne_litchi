<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embarquement extends Model
{
    use HasFactory;

    // Si le nom de la table n'est pas le pluriel du modèle
    protected $table = 'embarquement';

    // Définir les champs qui peuvent être remplis (mass assignable)
    protected $fillable = [
        'utilisateur_id',
        'compagne_id',
        'shift_id',
        'station_id',
        'navire_id',
        'numero_cal',
        'nombre_pallets'
    ];
}
