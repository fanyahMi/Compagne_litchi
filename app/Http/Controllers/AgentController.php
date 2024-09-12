<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Validation\ValidationException;
use Exception;
use Log;

class AgentController extends Controller
{

    public function logout(Request $request)
    {
        $request->session()->forget('agent');
        return redirect('/login');
    }
    public function login(Request $request)
    {
        if (!$request->session()->has('agent')) {
            return view('login');
        }
        return redirect()->route('admin.index');

    }


    public function index(){
        return view('template.Layout');
    }
    public function loginWeb(Request $request)
    {
        $validatedData = $request->validate([
            'matricule' => 'required',
            'motDePasse' => 'required|string',
        ], [
            'matricule.required' => 'Le matricule est obligatoire.',
            'motDePasse.required' => 'Le mot de passe est obligatoire.',
            'motDePasse.string' => 'Le mot de passe doit être une chaîne de caractères.',
        ]);

        try {
            $result = Agent::checkLoginWeb($validatedData['matricule'], $validatedData['motDePasse']);
            $request->session()->put('agent', [
                'matricule' => $result['matricule'],
                'role' => $result['role'],
            ]);
            return response()->json([
                'redirect' => url('/'),
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


}
