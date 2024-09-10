<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view("template.Layout", [
            'title' => 'Dashoard',
            'page' => "admin.Acceuil"
        ]);
    }
}
