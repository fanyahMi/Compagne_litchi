<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;


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
});


