<?php

namespace App\Http\Controllers;

use App\Models\ImportationQuotas;
use App\Models\Navire;
use App\Models\Station;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;

class   ImportExportController extends Controller
{
    public function exportModelStationNavire()
    {
        $navires = Navire::all();
        $stations = Station::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Nom Station');
        $sheet->setCellValue('C1', 'Navire');
        $sheet->setCellValue('B1', 'Numéro Station');
        $sheet->setCellValue('D1', 'Quotas');

        $rowIndex = 2;

        foreach ($stations as $station) {
            $sheet->setCellValue('A' . $rowIndex, $station->station);
            foreach ($navires as $navire) {
                $sheet->setCellValue('C' . $rowIndex, $navire->navire);
                $sheet->setCellValue('D' . $rowIndex, '');
                $rowIndex++;
                $sheet->setCellValue('A' . $rowIndex, $station->station);
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'stations_navires.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }



    /***** Importion des donnée ****/

    public function importQuotasNumero(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $validatedData = $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'compagne_id' => 'required'
        ], [
            'file.required' => 'Le champ file est obligatoire.',
            'compagne_id.required' => 'Le champ compagne est obligatoire.'
        ]);

        $filePath = $request->file('file')->getRealPath();
        $spreadsheet = IOFactory::load($filePath);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $check = false;
        $error = "";
        $valideData = array();
        foreach ($sheetData as $rowIndex => $row) {
           if($rowIndex != 1){
                $nomStation = trim($row['A']);
                $numeroStation = trim($row['B']);
                $navire = trim($row['C']);
                $quotas = str_replace(',', '', trim($row['D']))  ;

                if (!is_numeric($quotas)) {
                    $check = true;
                    $error .= " Le quotas sur la ligne ".$rowIndex ." doit un nombre <br>";
                }elseif($quotas < 0 ){
                    $check = true;
                    $error .= " Le quotas sur la ligne ".$rowIndex ." doit etre positif <br>";
                }

                $valideData[] = [
                    'station' => $nomStation,
                    'compagne_id' => intval($validatedData['compagne_id']),
                    'numero_station' => intval($numeroStation),
                    'navire' => $navire,
                    'quotas'=> (double)$quotas
                ];

           }
        }
        if($check == true){
            echo $error;
        }else{
            ImportationQuotas::insertImportation( $valideData);
        }

        return redirect('list-quotas');

    }

}
