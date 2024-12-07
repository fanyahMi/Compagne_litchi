<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Sorti_magasin extends Model
{
    protected $table = "sortant_magasin";
    protected $fillable = [
        'quantite_sortie',
        'date_sortie',
        'entree_magasin_id',
        'agent_id',
        'shift_id'
    ];

    public $timestamps = false;
    protected $primaryKey = "id_entree_magasin";
    public $incrementing = true;

    public static function createSortie($data)
    {
        $currentShift = DB::table('shift')
                ->where(function ($query) {
                    $query->whereRaw('CURRENT_TIME >= debut AND CURRENT_TIME <= fin');
                })
                ->orWhere(function ($query) {
                    $query->whereRaw('debut > fin AND (CURRENT_TIME >= debut OR CURRENT_TIME <= fin)');
                })
                ->value('id_shift');
        $data['shift_id'] = $currentShift;
        $data['date_sortie'] = Carbon::now();
        return self::create($data);
    }
}
