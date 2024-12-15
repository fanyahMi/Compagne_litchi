<?php

namespace App\Http\Controllers;

use App\Models\ImportationQuotas;
use App\Models\Navire;
use App\Models\Station;
use App\Models\Shift;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Log;
class   ImportExportController extends Controller
{
    public function index(){
        $compagnes = DB::table('compagne')
                        ->where('etat', 1)
                        ->get();
        return view('station.Importation', compact('compagnes'));
    }


    public function exportModelStationNavire()
    {
        $navires = Navire::all();
        $stations = Station::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Nom Station');
        $sheet->setCellValue('B1', 'Numéro Station');

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        $colIndex = 3; // Colonne D
        foreach ($navires as $navire) {
            $sheet->setCellValueByColumnAndRow($colIndex, 1, $navire->navire);
            $sheet->getColumnDimensionByColumn($colIndex)->setAutoSize(true); // Ajuster la largeur
            $colIndex++;
        }

        $rowIndex = 2;

        foreach ($stations as $station) {
            $sheet->setCellValue('A' . $rowIndex, $station->station);
            $sheet->setCellValue('B' . $rowIndex, $station->numero);

            $colIndex = 3;
            foreach ($navires as $navire) {
                $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, '');
                $colIndex++;
            }

            $rowIndex++;
        }

        $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

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
        $navireColumns = range('C', 'Z');
        $navireNames = [];
        foreach ($sheetData as $rowIndex => $row) {
            if ($rowIndex == 1) {
                foreach ($row as $col => $value) {
                    if ($col >= 'C' && !empty(trim($value))) {
                        $navireNames[] = trim($value);
                    }
                }
                break;
            }
        }

        foreach ($sheetData as $rowIndex => $row) {
            if ($rowIndex != 1) {
                $nomStation = trim($row['A']);
                $numeroStation = trim($row['B']);
                $quotas = [];

                foreach ($navireColumns as $key => $col) {
                    if (isset($row[$col]) && in_array(trim($sheetData[1][$col]), $navireNames)) {
                        $value = str_replace(',', '', trim($row[$col]));
                        if (!is_numeric($value)) {
                            $check = true;
                            $error .= " Le quotas $navireNames[$key] sur la ligne " . $rowIndex . " doit être un nombre ";
                        } elseif ($value < 0) {
                            $check = true;
                            $error .= " Le quotas $navireNames[$key] sur la ligne " . $rowIndex . " doit être positif";
                        }
                        echo trim( $col)."  -  ";
                        $quotas[ $navireNames[$key]] = (double)$value;
                    }
                }

                if (array_sum($quotas) > 0) {
                    foreach ($quotas as $navire => $quota) {
                        $valideData[] = [
                            'station' => $nomStation,
                            'compagne_id' => intval($validatedData['compagne_id']),
                            'numero_station' => intval($numeroStation),
                            'navire' => $navire,
                            'quotas' => $quota
                        ];
                    }
                }
            }
        }
        if ($check == true) {
            return redirect()->back()->withErrors($error);
        } else {
            ImportationQuotas::insertImportation($valideData);
        }

        return redirect('list-quotas');
    }


    public function exportRapport($idCampagne, $idNavire)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'SMMC PORT TOAMASINA');
        $sheet->setCellValue('A2', 'DIREX');
        $sheet->setCellValue('A3', 'DEPARTEMENT EXPLOITATION');
        $sheet->setCellValue('A4', 'SERVICE EXPERTISE');
        $sheet->setCellValue('A7', 'ETAT EMBARQUEMENT DES PALETTES PAR SHIFT');

        $rowIndex = 8;

        $shifts = Shift::all();
        $cales = DB::table('v_quantite_cales')
            ->where('id_navire', $idNavire)
            ->where('id_compagne', $idCampagne)
            ->get();

        DB::statement('SET @id_compagne = ?', [$idCampagne]);
        DB::statement('SET @id_navire = ?', [$idNavire]);
        $results = DB::select('CALL GeneratePivot2()');

        $columns = ['BATEAU', 'DATE', 'STATION'];
        $shiftColumnIndex = count($columns);

        foreach ($columns as $key => $column) {
            $sheet->setCellValue($this->getColonne($key) . $rowIndex, $column);
        }

        foreach ($shifts as $shift) {
            $startColumn = $this->getColonne($shiftColumnIndex);
            $endColumn = $this->getColonne($shiftColumnIndex + count($cales) - 1);

            $sheet->setCellValue($startColumn . $rowIndex, $shift->description);
            $sheet->mergeCells($startColumn . $rowIndex . ':' . $endColumn . $rowIndex);

            foreach ($cales as $cale) {
                $currentColumn = $this->getColonne($shiftColumnIndex);
                $sheet->setCellValue($currentColumn . ($rowIndex + 1), 'CALE ' . $cale->numero_cale);
                $shiftColumnIndex++;
            }
        }

        $totalColumn = $this->getColonne($shiftColumnIndex);
        $sheet->setCellValue($totalColumn . $rowIndex, 'TOTAL');

        $dataStartRow = $rowIndex + 2;
        foreach ($results as $result) {
            $sheet->setCellValue('A' . $dataStartRow, $result->BATEAU);
            $sheet->setCellValue('B' . $dataStartRow, $result->DATE);
            $sheet->setCellValue('C' . $dataStartRow, $result->STATION);

            $colIndex = count($columns);
            foreach ($shifts as $shift) {
                foreach ($cales as $cale) {
                    $cellValue = $result->{'Shift ' . $shift->id_shift . ' Cale ' . $cale->numero_cale} ?? 0;
                    $sheet->setCellValue($this->getColonne($colIndex) . $dataStartRow, $cellValue);
                    $colIndex++;
                }
            }

            $sheet->setCellValue($this->getColonne($colIndex) . $dataStartRow, $result->TOTAL_PALLETS);
            $dataStartRow++;
        }

        $lastColumn = $this->getColonne($shiftColumnIndex);
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);

        $sheet->getStyle('A' . $rowIndex . ':' . $lastColumn . ($dataStartRow - 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $writer = new Xlsx($spreadsheet);
        $filename = 'situation.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    private function getColonne($index)
    {
        $letter = '';
        while ($index >= 0) {
            $letter = chr($index % 26 + 65) . $letter;
            $index = intval($index / 26) - 1;
        }
        return $letter;
    }



}
