<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shift'; // Nom de la table
    protected $fillable = [
        'description',
        'debut',
        'fin',
    ];

    public $timestamps = false; // Pas de colonnes de timestamps
    protected $primaryKey = 'id_shift'; // Nom de la clé primaire
    public $incrementing = true; // Auto-increment
}

