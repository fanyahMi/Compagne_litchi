<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sorti_magasin extends Model
{
    protected $table = "entree_magasin";
    protected $fillable = [
        'quantite_sortie',
        'date_sortie',
        'entree_magasin_id',
        'agent_id'
    ];

    public $timestamps = false;
    protected $primaryKey = "id_entree_magasin";
    public $incrementing = true;
}
