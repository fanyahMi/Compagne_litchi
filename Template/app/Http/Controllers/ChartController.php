<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function donutData()
    {
       $labels = ['A', 'B', 'C', 'D', 'E'];
       $data = [10, 20, 30, 40, 50];
       $backgroundColors = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
        ];
        $borderColors = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
        ];

       return response()->json([
           'labels' => $labels,
           'data' => $data,
           'backgroundColors' => $backgroundColors,
           'borderColors' => $borderColors,
       ]);
    }
    public function secteureData()
    {
       $labels = ['A', 'B', 'C', 'D', 'E'];
       $data = [10, 20, 30, 40, 50];
       $backgroundColors = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
        ];
        $borderColors = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
        ];

       return response()->json([
           'labels' => $labels,
           'data' => $data,
           'backgroundColors' => $backgroundColors,
           'borderColors' => $borderColors,
       ]);
    }



    public function barChartData()
    {
        $salesData = [
            [
                'year' => 2022,
                'data' => [3000, 4500, 6000, 5500, 4000, 3500],
            ],
            [
                'year' => 2023,
                'data' => [3000, 4500, 6000, 5500, 4000, 3500],
            ],
            [
                'year' => 2024,
                'data' => [4000, 5000, 5500, 6000, 4500, 4000],
            ],
            // Ajoutez plus d'années si nécessaire
        ];

        // Les labels pour les mois
        $labels = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun'];

        // Tableau de couleurs
        $colors = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
        ];

        // Retourner les données au format JSON
        return response()->json([
            'labels' => $labels,
            'datasets' => array_map(function ($item, $index) use ($colors) {
                return [
                    'label' => 'Ventes ' . $item['year'],
                    'data' => $item['data'],
                    'backgroundColor' => $colors[$index % count($colors)], // Utilisez une couleur du tableau en boucle
                    'borderColor' => $colors[$index % count($colors)], // Utilisez la même couleur pour la bordure
                ];
            }, $salesData, array_keys($salesData))
        ]);
    }


    public function lineSimpleChartData()
    {
        $salesData = [
            '2023' => [1100, 1300, 1400, 1600, 1500, 1700, 1900, 1800, 2000, 2100, 2300, 2200], // Ventes mensuelles pour 2023
            '2024' => [1200, 1400, 1500, 1700, 1600, 1800, 2000, 1900, 2100, 2200, 2400, 2300], // Ventes mensuelles pour 2024
        ];

        $months = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'];

        $labels = [];
        foreach ($salesData as $year => $monthlySales) {
            foreach ($months as $index => $month) {
                $labels[] = $month . ' ' . $year;
            }
        }

        $allSalesData = [];
        foreach ($salesData as $year => $monthlySales) {
            $allSalesData = array_merge($allSalesData, $monthlySales);
        }

        $borderColor = 'rgba(54, 162, 235, 1)';

        return response()->json([
            'labels' => $labels,
            'data' => $allSalesData,
            'borderColor' => $borderColor,
        ]);
    }

    public function linePlusData()
    {
        $salesData = [
            '2022' => [500, 200, 300, 1500, 300, 600, 800, 700, 900, 1000, 200, 100],
            '2023' => [100, 300, 400, 950, 100, 100, 1000, 800, 2000, 100, 300, 200],
            '2024' => [200, 400, 500, 1700, 600, 100, 200, 900, 2100, 2200, 200, 200],
        ];
        $months = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'];

        $colors = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
        ];

        $datasets = [];
        $colorIndex = 0;
    foreach ($salesData as $year => $data) {
        $datasets[] = [
            'label' => $year,
            'data' => $data,
            'borderColor' => $colors[$colorIndex],
        ];
        $colorIndex = ($colorIndex + 1) % count($colors);
    }

        return response()->json([
            'labels' => $months,
            'datasets' => $datasets,
        ]);
    }


}
