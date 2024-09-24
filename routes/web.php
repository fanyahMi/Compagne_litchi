<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\NavireController;
use App\Http\Controllers\MagasinController;


Route::get('/logout', [AgentController::class, 'logout'])->name('logout');
Route::post('loginWeb', [AgentController::class, 'loginWeb']);
Route::get('/login', [AgentController::class, 'login'])->name('login');


Route::middleware(['admin'])->group(function () {
    Route::get('/', [AgentController::class, 'index'])->name('admin.index');
});
Route::middleware(['utilisateur'])->group(function () {
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


    Route::get('/list-navire', [NavireController::class, 'index']);
    Route::post('/ajout-navire', [NavireController::class, 'addnavire']) ->name('utilisateur.addAgent');
    Route::get('/get-navire', [NavireController::class, 'getNavire']);
    Route::get('/get-navire/{id}', [NavireController::class, 'getById']);
    Route::put('/update-navire', [NavireController::class, 'update']);



    Route::get('/entree-magasin', [MagasinController::class, 'index']);
    Route::post('/entree-magasin', [MagasinController::class, 'insertEntrer']);
});


