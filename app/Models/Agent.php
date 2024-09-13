<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Log;

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
        'situation_familial_id',
        'created_at'
    ];

    public $timestamps = false;
    protected $primaryKey = "id_utilisateur";
    public $incrementing = true;

    public function hashPassword($motDePasse)
    {
        $hashedPassword = Hash::make($motDePasse);
        return $hashedPassword;
    }

    public static function checkLoginWeb($matricule, $motDePasse)
    {
        try {
            $user = DB::table('v_utilisateur_global')
                ->select('matricule', 'role', 'mot_passe')
                ->where('matricule', $matricule)
                ->first();

            if ($user) {
                //if (Hash::check($motDePasse, $user->mot_passe)) {
                if ($motDePasse == $user->mot_passe) {
                    return [
                        'matricule' => $user->matricule,
                        'role' => $user->role,
                    ];
                } else {
                    throw new Exception('Mot de passe incorrect');
                }
            } else {
                throw new Exception('Matricule non trouvé');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function generateMatricule($numero){
            // Get the current date
            $now = now();

            // Format the year and month
            $year = $now->format('Y'); // Get the current year
            $month = $now->format('m'); // Get the current month

            // Generate the matricule
            $matricule = $year . $month . str_pad($numero, 2, '0', STR_PAD_LEFT); // Pad rank with zeros if needed

            return $matricule;

    }
}
