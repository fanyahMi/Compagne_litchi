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
    Route::post('/ajout_agent', [AgentController::class, 'addAgent']) ->name('utilisateur.addAgent');
});


