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

    public static function hashPassword($motDePasse)
    {
        $hashedPassword = Hash::make($motDePasse);
        return $hashedPassword;
    }

    public static function checkLoginWeb($matricule, $motDePasse)
    {
        try {
            $user = DB::table('v_utilisateur_global')
                ->select('matricule', 'role', 'mot_passe', 'id_utilisateur')
                ->where('matricule', $matricule)
                ->first();

            if ($user) {
                //if (Hash::check($motDePasse, $user->mot_passe)) {
                if ($motDePasse == $user->mot_passe) {
                    return [
                        'matricule' => $user->matricule,
                        'role' => $user->role,
                        'id' => $user->id_utilisateur,
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

    private static function getNumeroAgent(){
        $numero = Agent::whereYear('created_at', now()->year)
                     ->whereMonth('created_at', now()->month)
                     ->count() + 1;
        return $numero;
    }

    private static function generateMatricule(){
            $numero = Agent::getNumeroAgent();
            $now = now();
            $year = $now->format('Y');
            $month = $now->format('m');
            $matricule = $year . $month . str_pad($numero, 2, '0', STR_PAD_LEFT);
            return $matricule;
    }

    public  static function ajouterAgent($nom, $prenom, $dateNaissance, $cin, $sexeId, $situation,$roleId = 2){
        $matricule = Agent::generateMatricule();
        Agent::create([
            'matricule' => $matricule,
            'nom' => $nom,
            'prenom' => $prenom,
            'date_naissance' => $dateNaissance,
            'cin'=> $cin,
            'mot_passe' => Agent::hashPassword($matricule),
            'sexe_id' => $sexeId,
            'role_id' => $roleId ,
            'situation_familial_id' => $situation,
            'created_at' => now()
        ]);
    }

    public static function getAgentTableau() {
        $agents = Agent::orderBy('created_at', 'desc')->get();
        if ($agents->contains(function ($agent) {
            return in_array(null, $agent->toArray(), true) || in_array('', $agent->toArray(), true);
        })) {
            return ' ';
        }

        return $agents;
    }

    public static function getAgentById($id){
        try {
            return Agent::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error fetching agent: ' . $e->getMessage());
            throw new \Exception('Agent non trouvé.');
        }
    }

    public static function updateAgent($id, array $data)
    {
        try {
            $agent = Agent::findOrFail($id);
            $agent->update([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'date_naissance' => $data['dateNaissance'],
                'cin' => $data['cin'],
                'sexe_id' => $data['sexe'],
                'situation_familial_id' => $data['situation'],
            ]);
            return $agent;
        } catch (\Exception $e) {
            Log::error('Error updating agent: ' . $e->getMessage());
            throw new \Exception('Erreur lors de la mise à jour de l\'agent.');
        }
    }
}
