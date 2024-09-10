<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use League\Csv\Writer;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
    public function signIn(Request $request)
     {
        if ($request->session()->has('id_user')) {
            return redirect('/');
        }
         return view('auth.login');
     }

     public function signUp(Request $request){
        if ($request->session()->has('id_user')) {
            return redirect('/');
        }
        return view('auth.SignUp');
     }
     public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'first_names' => 'required',
            'date_birth' => 'required|date|before_or_equal:2006-12-31', // La date de naissance doit être avant ou égale à 31 décembre 2006
            'email' => 'required|email|unique:users,email',
            'passwords' => 'required|min:8',
            'passwords2' => 'required|same:passwords',
        ], [
           'name.required' => 'Le champ Name est requis.',
            'first_names.required' => 'Le champ First names est requis.',
            'date_birth.required' => 'Le champ Date of birth est requis.',
            'date_birth.date' => 'Le champ  <Strong style="color: aqua"> Date</Strong> of birth doit être une date valide.',
            'date_birth.before_or_equal' => __('La date de naissance <strong style="color: aqua">(:input)</strong> ne peut pas être supérieure à l\'année 2006.'),
            'email.required' => 'Le champ Email Address est requis.',
            'email.email' => 'Le champ Email Address doit être une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'passwords.required' => 'Le champ Password est requis.',
            'passwords.min' => 'Le champ Password doit avoir au moins :min caractères.',
            'passwords2.required' => 'Le champ Confirm Password est requis.',
            'passwords2.same' => 'Les champs Password et Confirm Password doivent correspondre.',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::createUser([
            'name' => $request->name,
            'first_names' => $request->first_names,
            'date_birth' => $request->date_birth,
            'email' => $request->email,
            'passwords' => ($request->passwords),
        ]);
        return redirect('/signIn')->with('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');
    }

     public function login(Request $request)
     {

        $email = $request->input('email');
        $password = $request->input('password');
        try {
            $response = User::check_login($email, $password);
            $request->session()->put('id_user', $response->id_user);
            $request->session()->put('name', $response->name);
            $request->session()->put('role', $response->role);
            $request->session()->put('emailUser', $response->email);
            return redirect()->intended('/');
        } catch (\Throwable $th) {
          return back()->withErrors(['email' => 'Adresse email ou mot de passe incorrect.']);
        }
     }


     public function logout(Request $request)
     {
        if (!$request->session()->has('id_user')) {
            return redirect('/signIn');
        }
        $request->session()->forget('id_user');
        $request->session()->forget('name');
        $request->session()->forget('role');
        return Redirect::to('signIn');
     }

     public function exportToCSV()
    {
        $users = User::all();

        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        // Ajouter les en-têtes
        $csv->insertOne(['ID', 'Name', 'First Names', 'Date of Birth', 'Email', 'Role']);

        // Ajouter les données
        foreach ($users as $user) {
            $csv->insertOne([
                $user->id_user,
                $user->name,
                $user->first_names,
                $user->date_birth,
                $user->email,
                $user->role
            ]);
        }

        // Télécharger le fichier CSV
        $csv->output('users.csv');
    }

    public function exportToExcel()
    {
        $users = User::all();
        $filename = 'users_' . date('Y_m_d_H_i_s') . '.xlsx';
        return (new FastExcel($users))->download($filename);
    }



}
