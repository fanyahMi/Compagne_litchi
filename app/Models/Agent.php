<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = "utilisateur";
    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'date_naissance',
        'cin',
        'mot_passe',
        'sexe_id',
        'role_id',
        'situation_familial_id'
    ];

    public $timestamps = false;
    protected $primaryKey = "id_utilisateur";
    public $incrementing = true;
}
