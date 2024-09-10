<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "users";

    protected $fillable = [
        'name',
        'first_names',
        'date_birth',
        'email',
        'passwords',
        'role',
    ];

    public $timestamps = false;
    protected $primaryKey = "id_user";
    public $incrementing = false;

    // Attributs supplémentaires non liés à la table de base de données



    public static function check_login($email, $password){
        try {
            $cle = env('CUSTOM_KEY');
            $password = $password . $cle;

            $result = DB::table('users')
                        ->where('email', $email)
                        ->first();

            if ($result && Hash::check($password, $result->passwords)) {
                return $result;
            } else {
                throw new \Exception('Adresse email ou mot de passe incorrect.');
            }
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            throw $th;
        }
    }

    public static function createUser(array $userData)
    {
        $cle = env('CUSTOM_KEY');
        $userData['passwords'] = Hash::make(($userData['passwords'].$cle));
        $userData['role'] = $userData['role'] ?? 0;
        return self::create($userData);
    }

}
