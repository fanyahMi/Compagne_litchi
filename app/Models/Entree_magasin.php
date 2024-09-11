<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entree_magasin extends Model
{
    protected $table = "entree_magasin";
    protected $fillable = [
        'numero_camion',
        'bon_livraison',
        'chauffeur',
        'quantite_palette',
        'date_entrant',
        'agent_id',
        'station_id',
        'magasin_id'
    ];

    public $timestamps = false;
    protected $primaryKey = "id_entree_magasin";
    public $incrementing = true;
}
