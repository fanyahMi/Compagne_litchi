<?php

namespace App\Http\Controllers\models;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Session;

class Controllers extends Controller
{
    public function formgeneralize()
    {
        $selectOptions = collect([
            (object) ['id' => 1, 'name' => 'Option 1'],
            (object) ['id' => 2, 'name' => 'Option 2'],
            (object) ['id' => 3, 'name' => 'Option 3'],
        ]);

        $checkboxOptions = collect([
            (object) ['id' => 'checkbox1', 'name' => 'Checkbox Option 1'],
            (object) ['id' => 'checkbox2', 'name' => 'Checkbox Option 2'],
            (object) ['id' => 'checkbox3', 'name' => 'Checkbox Option 3'],
            (object) ['id' => 'checkbox4', 'name' => 'Checkbox Option 4'],
        ]);

        $radioOptions = collect([
            (object) ['id' => 'radioOption1', 'name' => 'Radio Option 1'],
            (object) ['id' => 'radioOption2', 'name' => 'Radio Option 2'],
            (object) ['id' => 'radioOption3', 'name' => 'Radio Option 3'],
            (object) ['id' => 'radioOption4', 'name' => 'Radio Option 4'],
        ]);


        return view("template.Layout", [
            'title' => 'Dashboard',
            'page' => "template.form.Form",
            'selectOptions' => $selectOptions,
            'checkboxOptions' => $checkboxOptions,
            'radioOptions' => $radioOptions,
        ]);
    }


    public function addform(Request $request)
    {

         // Définition des règles de validation
         $rules = [
            'textI' => 'required|string|max:255',
            'numberI' => 'required|numeric|min:0',
            'dateI' => 'required|date',
            'selectI' => 'required|in:1,2,3',
            'textareaI' => 'required|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:12048',
            'csv_fileI' => 'required|file|mimes:csv,txt',
            'excel_fileI' => 'required|file|mimes:xlsx,xls',
            'checkbox' => 'required|array|min:1',
            'checkbox.*' => 'in:checkbox1,checkbox2,checkbox3,checkbox4',
            'radio' => 'required|in:radioOption1,radioOption2,radioOption3,radioOption4',
        ];

        // Messages d'erreur personnalisés en français
$messages = [
    'checkbox.array' => 'Le champ :attribute doit être un tableau.',
    'checkbox.min' => 'Veuillez sélectionner au moins une option pour la case à cocher.',
    'radio.required' => 'Veuillez sélectionner une option pour le bouton radio.',
    'images.*.required' => 'Au moins une image doit être sélectionnée.',
    'images.*.image' => 'Veuillez sélectionner une image valide.',
    'images.*.mimes' => 'Les images doivent être de type jpeg, png, jpg ou gif.',
    'images.*.max' => 'La taille maximale de l\'image est de :max kilo-octets.',
    'numberI.required' => 'Le champ numberI est obligatoire.',
    'numberI.numeric' => 'La valeur saisie pour le champ numberI (:input) doit être un nombre positif.',
    'numberI.min' => 'La valeur saisie pour le champ numberI (:input) doit être supérieure ou égale à :min.',
    'textI.required' => 'Le champ textI est obligatoire.',
    'textI.string' => 'La valeur saisie pour le champ textI doit être une chaîne de caractères.',
    'textI.max' => 'Le champ textI ne doit pas dépasser :max caractères.',
    'dateI.required' => 'Le champ dateI est obligatoire.',
    'dateI.date' => 'La valeur saisie pour le champ dateI (:input) doit être une date valide.',
    'selectI.required' => 'Le champ selectI est obligatoire.',
    'selectI.in' => 'La valeur saisie pour le champ selectI (:input) n\'est pas valide.',
    'textareaI.required' => 'Le champ textareaI est obligatoire.',
    'textareaI.string' => 'La valeur saisie pour le champ textareaI doit être une chaîne de caractères.',
    'csv_fileI.required' => 'Le fichier CSV est obligatoire.',
    'csv_fileI.file' => 'Veuillez sélectionner un fichier CSV valide.',
    'csv_fileI.mimes' => 'Le fichier CSV doit être de type :values.',
    'excel_fileI.required' => 'Le fichier Excel est obligatoire.',
    'excel_fileI.file' => 'Veuillez sélectionner un fichier Excel valide.',
    'excel_fileI.mimes' => 'Le fichier Excel doit être de type :values.',
];


        // Validation des données du formulaire
        $validator = Validator::make($request->all(), $rules, $messages);

        // Vérification si la validation a échoué
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validation des données du formulaire

        $text = $request->input('text');
        $number = $request->input('number');
        $date = $request->input('date');
        $select = $request->input('select');
        $textarea = $request->input('textarea');
        $checkbox = $request->input('checkbox');
        $radio = $request->input('radio');

        // Affichage des valeurs des champs du formulaire
        echo "Text: $text <br>";
        echo "Number: $number <br>";
        echo "Date: $date <br>";
        echo "Select: $select <br>";
        echo "Textarea: $textarea <br>";
        echo "Checkbox: <br>";
        foreach($checkbox as $value){
            echo $value . "<br>";
        }
        echo "<br>";
        echo "Radio: $radio <br>";

        // Afficher les fichiers téléchargés
        $images = $request->file('images');
        $csvFile = $request->file('csv_file');
        $excelFile = $request->file('excel_file');

        // Save Image
        if ($request->hasFile('images')) {
            Upload::uploadImage($images);
        }

        if ($request->hasFile('csv_fileI')) {
            $csvFile = $request->file('csv_fileI');
            $csvFilePath = $csvFile->store('csv_files');

        }



        echo "----------------------------------------------";
      // Importation du fichier Excel
        if ($request->hasFile('excel_fileI')) {
            $excelFile = $request->file('excel_fileI');
            $excelFilePath = $excelFile->store('excel_files');

            // Appel de la méthode pour importer l'Excel
            Upload::importExcel($excelFilePath);
        }

    }

    // Export pdf
    public function pdf()
    {
        $html = Upload::genererPDF();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('facture.pdf');
    }


    public function getDetail($id)
    {
        // Exemple de données statiques
        $detail = [
            'id' => $id,
            'text' => 'Exemple de texte',
            'number' => 42,
            'date' => '2024-05-05',
            'select' => 2, // Exemple d'ID de l'option sélectionnée dans la liste déroulante
            'textarea' => 'Contenu de l\'exemple de zone de texte',
            'checkbox' => ['checkbox1', 'checkbox3'], // Exemple d'ID des cases à cocher cochées
            'radio' => 'radioOption2', // Exemple d'ID du bouton radio sélectionné
        ];

        return response()->json($detail);
    }

    public function updateM(Request $request)
    {
        // Règles de validation
        $rules = [
            'inputText' => 'required|string|max:255',
            'inputNumber' => 'required|numeric|min:0',
            'inputdate' => 'required|date',
            'imageM.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'csv_fileM' => 'required|file|mimes:csv,txt|max:2048',
            'excel_fileM' => 'required|file|mimes:xlsx,xls|max:2048',
            'inputSelect' => 'required',
            'textareaM' => 'required|string',
        ];

        // Messages d'erreur personnalisés
        $messages = [
            'inputText.required' => 'Le champ texte est requis.',
            'inputText.string' => 'Le champ texte doit être une chaîne de caractères.',
            'inputText.max' => 'Le champ texte ne doit pas dépasser :max caractères.',
            'inputNumber.required' => 'Le champ nombre est requis.',
            'inputNumber.numeric' => 'Le champ nombre doit être un nombre.',
            'inputNumber.min' => 'doit être supérieur à :min.',
            'inputdate.required' => 'Le champ date est requis.',
            'inputdate.date' => 'Le champ date doit être une date valide.',
            'imageM.*.image' => 'Le fichier doit être une image.',
            'imageM.*.mimes' => 'Le fichier doit être de type :values.',
            'imageM.*.max' => 'Le fichier ne doit pas dépasser :max Ko.',
            'csv_fileM.file' => 'Le fichier doit être de type CSV.',
            'csv_fileM.mimes' => 'Le fichier doit être de type :values.',
            'csv_fileM.max' => 'Le fichier ne doit pas dépasser :max Ko.',
            'excel_fileM.required' => 'Le champ fichier Excel est requis.',
            'excel_fileM.file' => 'Le fichier doit être de type Excel.',
            'excel_fileM.mimes' => 'Le fichier doit être de type :values.',
            'excel_fileM.max' => 'Le fichier ne doit pas dépasser :max Ko.',
            'inputSelect.required' => 'Veuillez sélectionner une option.',
            'textareaM.required' => 'Le champ zone de texte est requis.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        return response()->json(['success' => 'Données mises à jour avec succès.']);
    }


    public function importFinal(Request $request)
    {
        // Définition des règles de validation
        $rules = [
            'csv_fileImp' => 'required|file|mimes:csv,txt',
            'excel_fileImp' => 'required|file|mimes:xlsx,xls',
        ];

        // Messages d'erreur personnalisés en français
        $messages = [
            'csv_fileImp.required' => 'Le champ import CSV est obligatoire',
            'csv_fileImp.file' => 'Le fichier doit être de type CSV.',
            'csv_fileImp.mimes' => 'Le fichier doit être de type :values.',
            'excel_fileImp.required' => 'Le champ import XLS, XLSX est obligatoire',
            'excel_fileImp.file' => 'Le fichier doit  être de type XLS ou XLSX',
            'excel_fileImp.mimes' => 'Le fichier doit être de type :values.',
        ];

        // Validation des données du formulaire
        $validator = Validator::make($request->all(), $rules, $messages);

        // Vérification si la validation a échoué
        if ($validator->fails()) {
            // Si la requête est une requête AJAX, retourner les erreurs au format JSON
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            // Sinon, afficher les erreurs dans le modal errorModal
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Importation du fichier CSV
        if ($request->hasFile('csv_fileImp')) {
            $csvFile = $request->file('csv_fileImp');
            $csvFilePath = $csvFile->store('csv_files');

            // Appel de la méthode pour importer le CSV
            $errors = Upload::importCsvFinal($csvFilePath);

            // Vérification s'il y a des erreurs
            if (!empty($errors)) {
                // Si la requête est une requête AJAX, retourner les erreurs au format JSON
                if ($request->ajax()) {
                    return response()->json(['errors' => $errors], 422);
                }
                // Sinon, afficher les erreurs dans le modal errorModal
                return redirect()->back()->with(['errors' => $errors]);
            }
        }

        // Importation du fichier Excel
        if ($request->hasFile('excel_fileImp')) {
            $excelFile = $request->file('excel_fileImp');
            $excelFilePath = $excelFile->store('excel_files');

            // Appel de la méthode pour importer l'Excel
            // Upload::importExcel($excelFilePath);
        }

        // Si la requête est une requête AJAX, retourner un message de succès au format JSON
        if ($request->ajax()) {
            return response()->json(['success' => 'Importation réussie.'], 200);
        }

        // Redirection avec message de succès si tout s'est bien passé
        return redirect()->back()->with('success', 'Importation réussie.');
    }


}
