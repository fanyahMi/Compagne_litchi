<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempTableSeance extends Model
{
    protected $table = "temp_table_seance";
    protected $fillable = [
        'idseance',
        'nom_film',
        'categorie_film',
        'date',
        'heure',
    ];

    public $timestamps = false;
    //protected $primaryKey = "idadmin";
    public $incrementing = false;
}
