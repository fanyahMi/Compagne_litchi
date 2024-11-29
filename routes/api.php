<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\NavireController;
use App\Http\Controllers\CompagneController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\EmbarquementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/****** API ****/
Route::post('v1/login', [AgentController::class, 'loginApi']);

Route::middleware('jwt')->group(function () {
  // Récupérer tous les navires en place (collection)
    Route::get('/v1/navires/en-place', [NavireController::class, 'getNaviresEnPlace']);

    // Récupérer la campagne en cours
    Route::get('/v1/campagnes/en-cours', [CompagneController::class, 'getCompagneEnCours']);

    // Récupérer les shifts en cours (si plusieurs shifts peuvent être en cours)
    Route::get('/v1/shifts/en-cours', [ShiftController::class, 'getShiftsEnCours']);

    // Récupérer un navire spécifique par son ID
    Route::get('/v1/navires/{idNavire}', [NavireController::class, 'getDetailNavireApi']);
    Route::get('/v1/campagnes/stations/numero-stations', [StationController::class, 'getNumeroStationCampagneEnCours']);
    Route::post('/v1/embarquements/historiques/cale', [EmbarquementController::class, 'rechercherHistoriqueCale']);
    Route::post('/v1/embarquements/historiques/navires/embarquements', [EmbarquementController::class, 'rechercherHistoriqueNavire']);
    Route::post('/v1/embarquements', [EmbarquementController::class, 'embarquer']);

});
