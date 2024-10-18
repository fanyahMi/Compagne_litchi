<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\NavireController;
use App\Http\Controllers\MagasinController;
use App\Http\Controllers\CompagneController;


Route::get('/logout', [AgentController::class, 'logout'])->name('logout');
Route::post('loginWeb', [AgentController::class, 'loginWeb']);
Route::get('/login', [AgentController::class, 'login'])->name('login');


Route::middleware(['admin'])->group(function () {
    Route::get('/', [AgentController::class, 'index'])->name('admin.index');
});

Route::middleware(['agent.sortie'])->group(function () {

});

Route::middleware(['agent.embarquement'])->group(function () {

});

Route::middleware(['agent.entree'])->group(function () {
    Route::get('/', [AgentController::class, 'index'])->name('admin.index');
    Route::post('/ajout-agent', [AgentController::class, 'addAgent']) ->name('utilisateur.addAgent');
    Route::get('/get-agent', [AgentController::class, 'getAgent']);
    Route::get('/get-agent/{id}', [AgentController::class, 'getById']);
    Route::delete('/supp-agent/{id}', [AgentController::class, 'dropAgent']);
    Route::put('/update-agent', [AgentController::class, 'update']);


    Route::get('/list-Station', [StationController::class, 'index']);
    Route::post('/ajout-station', [StationController::class, 'addStation']);
    Route::get('/get-station', [StationController::class, 'getStation']);
    Route::get('/get-station/{id}', [StationController::class, 'getById']);
    Route::put('/update-station', [StationController::class, 'update']);
    Route::get('/list-quotas', [StationController::class, 'quotas']);


    Route::get('/list-compagne', [CompagneController::class, 'compagne']);
    Route::post('/ajout-compagne', [CompagneController::class, 'addAnnee_compagne']);


    Route::get('/list-navire', [NavireController::class, 'index']);
    Route::post('/ajout-navire', [NavireController::class, 'addnavire']) ->name('utilisateur.addAgent');
    Route::get('/get-navire', [NavireController::class, 'getNavire']);
    Route::get('/get-navire/{id}', [NavireController::class, 'getById']);
    Route::put('/update-navire', [NavireController::class, 'update']);



    Route::get('/entree-magasin', [MagasinController::class, 'index']);
    Route::post('/entree-magasin', [MagasinController::class, 'insertEntrer'])->name('entre.store');
    Route::get('/sortie-magasin', [MagasinController::class, 'formSortie']);
    Route::get('/magasin-camion', [MagasinController::class, 'listeCamion']);
    Route::post('/sortie-magasin', [MagasinController::class, 'ajouteSortie'])->name('sortie.store');
    Route::get('/get-sortie', [MagasinController::class, 'getSortie']);
    Route::get('/quantite-entree/{id}', [MagasinController::class, 'getQuantiteEntrant'])->name('quantite.entrant');
    Route::get('/get-entree', [MagasinController::class, 'getEntree']);
    Route::get('/get-entree/{id}', [MagasinController::class, 'getById']);
    Route::post('/entree-magasin/modifier', [MagasinController::class, 'modifierEntrer'])->name('entre.modifier');
});


