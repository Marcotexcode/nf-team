<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CollaboratoriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PresenzeControllerJq;
use App\Http\Controllers\PresenzeControllerJs;
use App\Http\Controllers\ProfiloController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportDettagliatoController;
use App\Http\Controllers\RicevuteController;
use App\Http\Controllers\UtentiController;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {

    // Collaboratori
    Route::get('/collaboratori', [CollaboratoriController::class, 'index'])->name('collaboratori.index');
    Route::get('/collaboratore/crea', [CollaboratoriController::class, 'create'])->name('collaboratore.create');
    Route::post('/collaboratore', [CollaboratoriController::class, 'store'])->name('collaboratore.store');
    Route::get('/collaboratore/{collaboratore}/modifica', [CollaboratoriController::class, 'edit'])->name('collaboratore.edit');
    Route::put('/collaboratore/{collaboratore}', [CollaboratoriController::class, 'update'])->name('collaboratore.update');
    Route::delete('/collaboratore/{collaboratore}', [CollaboratoriController::class, 'destroy'])->name('collaboratore.destroy');


    // Presenze JQ
    Route::get('/presenze-jquery/{data}', [PresenzeControllerJq::class, 'index'])->name('presenze.index');
    Route::get('/datiPresenza', [PresenzeControllerJq::class, 'datiPresenza']);
    Route::get('/datiCollaboratore', [PresenzeControllerJq::class, 'datiCollaboratore']);
    Route::delete('/eliminaPresenza', [PresenzeControllerJq::class, 'destroy']);
    Route::post('/crea_aggiorna_presenza', [PresenzeControllerJq::class, 'creaAggiornaPresenza'])->name('presenze.creaAggiornaPresenza');


    // Presenze JS
    Route::get('/presenze-vanillaJs/{data}', [PresenzeControllerJs::class, 'index'])->name('calendario.index');
    Route::post('/crea_aggiorna', [PresenzeControllerJs::class, 'creaAggiorna'])->name('calendario.creaAggiorna');
    Route::get('/datiColl', [PresenzeControllerJs::class, 'datiCollaboratore']);
    Route::get('/datiPres', [PresenzeControllerJs::class, 'datiPresenze']);


    // Profilo
    Route::view('/secondo-fattore', 'profilo.secondoFattore')->name('secondo.fattore');
    Route::get('/profilo', [ProfiloController::class, 'index'])->name('profilo.index');
    Route::put('/profilo', [ProfiloController::class, 'update'])->name('profilo.update');
    Route::delete('/profilo', [ProfiloController::class, 'destroy'])->name('profilo.destroy');


    // Report
    Route::get('/report', [ReportController::class, 'indiceReport'])->name('indiceReport');
    Route::post('/report_filtro', [ReportController::class, 'filtroDate'])->name('filtroDate');


    // Report dettagliato
    Route::get('/report_dettagliato', [ReportDettagliatoController::class, 'indiceReportDettagliato'])->name('indiceReportDettagliato');
    Route::post('/filtro_report_dettagliato', [ReportDettagliatoController::class, 'filtroReportDettagliato'])->name('filtroReportDettagliato');


    // Ricevute
    Route::get('/ricevute', [RicevuteController::class, 'index'])->name('ricevute.index');
    Route::post('/ricevute_filtro', [RicevuteController::class, 'filtroMese'])->name('filtroMese');
    Route::post('/ricevute_nome', [RicevuteController::class, 'filtroNome'])->name('filtroNome');

    // Snappy
    Route::get('download_ricevute', [RicevuteController::class, 'downloadPDF'])->name('stampaPDF');


    // Utenti
    Route::middleware('can:administer')->group(function () {
        Route::get('/utenti', [UtentiController::class, 'index'])->name('utenti.index');
        Route::get('/utente/crea', [UtentiController::class, 'create'])->name('utente.create');
        Route::post('/utenti', [UtentiController::class, 'store'])->name('utente.store');
        Route::get('/utente/{utente}/modifica', [UtentiController::class, 'edit'])->name('utente.edit');
        Route::put('/utente/{utente}', [UtentiController::class, 'update'])->name('utente.update');
        Route::delete('/utente/{utente}', [UtentiController::class, 'destroy'])->name('utente.destroy');
    });

});


