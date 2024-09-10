<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
     protected $table = "departments";
    protected $fillable = [
        'department_name',
    ];

    public $timestamps = false;
    protected $primaryKey = "department_id";
    public $incrementing = false;
}
