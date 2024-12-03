<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campagne extends Model
{
    use HasFactory;
    protected $table = 'compagne';

    protected $fillable = [
        'annee',
        'debut',
        'fin',
        'etat'
    ];
    public $timestamps = false;
    protected $primaryKey = "id_compagne";
    public $incrementing = true;
}
