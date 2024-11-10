<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Log;

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

    public static function updateNavire($id, array $data)
    {
        try {
            $navire = Navire::findOrFail($id);
            $navire->update([
                'navire' => $data['nom'],
                'nb_compartiment' => $data['nb_compartiment'],
                'quantite_max' => $data['quantite_max'],
                'type_navire_id' => $data['type_navire'],
            ]);
            return $navire;
        } catch (\Exception $e) {
            Log::error('Error updating navire: ' . $e->getMessage());
            throw new \Exception('Erreur lors de la mise à jour du navire.');
        }
    }
}
