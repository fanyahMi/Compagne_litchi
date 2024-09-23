<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Log;

class MagasinController extends Controller
{
    public function index(){
        $navires = DB::table('navire')
                    ->select('id_navire', 'navire','quantite_max')
                    ->get();
        $stations = DB::table('station')
                    ->select('id_station', 'station')
                    ->get();

        return view('magasin.Entree', compact('navires', 'stations'));
    }
}
