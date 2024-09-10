<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recherche;
use App\Models\Departments;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
use App\Mail\ConfirmationMail;
class RechercheController extends Controller
{
    public function tableau(Request $request){
        $rec = Recherche::orderBy('id', 'asc')->paginate(10);

        if ($request->ajax()) {
            return view('template.tableau.Tableau', ['recherches' => $rec])->render();
        }

        return view("template.Layout", [
            'title' => 'Dashboard',
            'page' => "template.tableau.Liste",
            'recherches' => $rec
        ]);
    }

    public function tableauNormal(Request $request){
        $rec = Recherche::orderBy('id', 'asc')->paginate(10);

        return view("template.Layout", [
            'title' => 'Dashboard',
            'page' => "template.tableauNormal.Liste",
            'recherches' =>  $rec
        ]);
    }

    public function recherche(){

        return view("template.Layout", [
            'title' => 'Dashboard',
            'page' => "template.recherche.Recherche",
            'recherches' => [],
            'departments' => Departments::all()
        ]);
    }

    public function fulltext(Request $request){
        $rules = [
            'fulltext' => 'required|string|max:255',
        ];
        $messages = [
                'fulltext.required' => 'Le champ  est obligatoire.',
                'fulltext.string' => 'La valeur saisie  doit être une chaîne de caractères.',
                'fulltext.max' => 'Le champ fulltext ne doit pas dépasser :max caractères.',
            ];
                $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $text = $request->input('fulltext');
        try {
            /*$results = DB::select("
                SELECT *
                FROM v_employee_details
                WHERE to_tsvector('french', CONCAT_WS(' ', first_name, last_name, email, phone_number, address, hire_date::text, salary::text))
                @@ to_tsquery('french', ?)
            ", [$text]);*/


            $searchTerms = explode(' ', $text); // Sépare les mots-clés

            // Construit la clé de recherche dynamique
            $searchKey = implode(' & ', $searchTerms);


            $results = DB::table('v_employee_details')
            ->select('*')
            ->where(function ($query) use ($searchKey) {
                $query->whereRaw("to_tsvector('french', CONCAT_WS(' ', first_name, last_name,
                                department_name, email, phone_number, address ,  hire_date::text, salary::text))
                                @@ plainto_tsquery('french', ?)", [$searchKey]);
            })
            ->paginate(3)
            ->withQueryString();

           /* return view("template.Layout", [
                'title' => 'Dashboard',
                'page' => "template.recherche.Recherche",
                'recherches' => $results,
                'departments' => Departments::all()
            ]); */
        } catch (\Exception $e) {
           return view("template.Layout", [
                'title' => 'Dashboard',
                'page' => "template.recherche.Recherche",
                'recherches' => [],
                'departments' => Departments::all()
            ]);
        }

    }


    public function multimot(Request $request){
        $rules = [
            'multimot' => 'required|string|max:255',
        ];
        $messages = [
                'multimot.required' => 'Le champ  est obligatoire.',
                'multimot.string' => 'La valeur saisie  doit être une chaîne de caractères.',
                'multimot.max' => 'Le champ multimot ne doit pas dépasser :max caractères.',
            ];
                $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $searchTerm = $request->input('multimot');
        try {
            $results =  DB::table('employees')
            ->select('employees.employee_id', 'employees.first_name', 'employees.last_name', 'employees.department_id', 'departments.department_name', 'employees.hire_date', 'employees.salary', 'employee_details.email', 'employee_details.phone_number', 'employee_details.address')
            ->join('departments', 'employees.department_id', '=', 'departments.department_id')
            ->join('employee_details', 'employees.employee_id', '=', 'employee_details.employee_id')
            ->where(function ($query) use ($searchTerm) {
                $query->where('employees.first_name', 'LIKE', "%$searchTerm%")
                    ->orWhere('employees.last_name', 'LIKE', "%$searchTerm%")
                    ->orWhere('departments.department_name', 'LIKE', "%$searchTerm%")
                    ->orWhere('employee_details.email', 'LIKE', "%$searchTerm%")
                    ->orWhere('employee_details.phone_number', 'LIKE', "%$searchTerm%")
                    ->orWhere('employee_details.address', 'LIKE', "%$searchTerm%");
            })
            ->paginate(3)
            ->withQueryString();
            return view("template.Layout", [
                'title' => 'Dashboard',
                'page' => "template.recherche.Recherche",
                'recherches' => $results,
                'departments' => Departments::all()
            ]);
        } catch (\Exception $e) {
           return view("template.Layout", [
                'title' => 'Dashboard',
                'page' => "template.recherche.Recherche",
                'recherches' => [],
                'departments' => Departments::all()
            ]);
        }

    }

    public function multicritere(Request $request)
{
    $query = DB::table('v_employee_details');

    if ($request->filled('department')) {
        $query->where('department_id', $request->department);
    }

    if ($request->filled('min_salary') && is_numeric($request->min_salary)) {
        $query->where('salary', '>=', $request->min_salary);
    }

    if ($request->filled('max_salary') && is_numeric($request->max_salary)) {
        $query->where('salary', '<=', $request->max_salary);
    }

    if ($request->filled('start_date')) {
        $startDate = date('Y-m-d', strtotime($request->start_date));
        $query->where('hire_date', '>=', $startDate);
    }

    if ($request->filled('end_date')) {
        $endDate = date('Y-m-d', strtotime($request->end_date));
        $query->where('hire_date', '<=', $endDate);
    }

    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where(function($q) use ($keyword) {
            $q->where('first_name', 'like', "%$keyword%")
              ->orWhere('last_name', 'like', "%$keyword%")
              ->orWhere('email', 'like', "%$keyword%")
              ->orWhere('phone_number', 'like', "%$keyword%")
              ->orWhere('address', 'like', "%$keyword%");
        });
    }

    $results = $query->paginate(3)
                    ->withQueryString();;

    return view("template.Layout", [
        'title' => 'Dashboard',
        'page' => "template.recherche.Recherche",
        'recherches' => $results,
        'departments' => Departments::all()
    ]);
}


    public function rechercheTableau(Request $request){
        $searchTerm = $request->input('recherche');
        $searchTerms = explode(' ', $searchTerm);

        $results = DB::table('exemple')
            ->where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('texte_texte', 'Ilike', '%' . $term . '%')
                        ->orWhere('texte_varchar', 'Ilike', '%' . $term . '%')
                        ->orWhere('nombre_entier', 'Ilike', '%' . $term . '%')
                        ->orWhere('nombre_decimal', 'Ilike', '%' . $term . '%')
                        ->orWhere('nombre_double', 'Ilike', '%' . $term . '%')
                        ->orWhere('date_col', 'Ilike', '%' . $term . '%')
                        ->orWhere('heure_col', 'Ilike', '%' . $term . '%')
                        ->orWhere('timestamp_col', 'Ilike', '%' . $term . '%')
                        ->orWhere('bool_col', 'Ilike', '%' . $term . '%');
                }
            })
            ->paginate(200);

          return view('template.tableauNormal.Tableau', ['recherches' =>  $results]);
    }


    public function viderTables()
    {
        DB::statement('TRUNCATE TABLE film cascade');
        DB::statement('TRUNCATE TABLE categorie_film cascade');
        DB::statement('TRUNCATE TABLE seance cascade');

        return redirect()->back();
    }

}
