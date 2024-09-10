<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\models\Controllers;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\UsersController;


/*****MidlWare ****/
use App\Http\Middleware\CheckUserSession;
use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckUserRole;


Route::middleware([CheckUserSession::class, CheckAdminRole::class])->group(function () {
    Route::get('/viderTables', [RechercheController::class, 'viderTables'])->name('viderTables');
});

Route::middleware([CheckUserSession::class,  CheckUserRole::class])->group(function () {
    Route::get('/export/csv', [UsersController::class, 'exportToCSV'])->name('export.csv');
    Route::get('/export/excel', [UsersController::class, 'exportToExcel'])->name('export.excel');
    Route::get('/pdf', [Controllers::class, 'pdf'])->name('pdf');
});

Route::middleware([CheckUserSession::class])->group(function () {
    Route::get('/formgeneralize', [Controllers::class, 'formgeneralize'])->name('formgeneralize');
    Route::get('/formUpdate/{id}', [Controllers::class, 'getDetail'])->name('formUpdate/{id}');
    Route::post('/addform', [Controllers::class, 'addform'])->name('addform');
    Route::post('/updateM', [Controllers::class, 'updateM'])->name('updateM');
    Route::post('/importerFinal', [Controllers::class, 'importFinal'])->name('importerFinal');
    Route::get('/recherche', [RechercheController::class, 'recherche'])->name('recherche');
    Route::get('/fulltext', [RechercheController::class, 'fulltext'])->name('fulltext');
    Route::get('/multimot', [RechercheController::class, 'multimot'])->name('multimot');
    Route::get('/multicritere', [RechercheController::class, 'multicritere'])->name('multicritere');
    Route::get('/tableau', [RechercheController::class, 'tableau'])->name('tableau');
    Route::get('/rechercheTableau', [RechercheController::class, 'rechercheTableau'])->name('rechercheTableau');
    Route::get('/tableauNormal', [RechercheController::class, 'tableauNormal'])->name('tableauNormal');
});

//Mail
Route::get('/sendMail', [MailController::class, 'sendMail'])->name('sendMail');

//Login
Route::get('/signIn', [\App\Http\Controllers\UsersController::class, 'signIn'])->name('signIn');
Route::get('/signUp',\App\Http\Controllers\UsersController::class . '@signUp');
Route::post('/register',\App\Http\Controllers\UsersController::class . '@register');
Route::get('/logout',\App\Http\Controllers\UsersController::class . '@logout');
Route::post('/login',\App\Http\Controllers\UsersController::class . '@login');

//Chart
Route::get('/chart-donutData', [ChartController::class, 'donutData']);
Route::get('/chart-secteureData', [ChartController::class, 'secteureData']);
Route::get('/chart-barChartData', [ChartController::class, 'barChartData']);
Route::get('/chart-lineSimpleChartData', [ChartController::class, 'lineSimpleChartData']);
Route::get('/chart-linePlusData', [ChartController::class, 'linePlusData']);




//Admin
Route::get('/', [AdminController::class, 'index'])->middleware('checkUserSession');


