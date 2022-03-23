<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UtentiController;
use App\Http\Controllers\CollaboratoriController;
use App\Http\Controllers\PresenzeController;
use App\Http\Controllers\RicevuteController;




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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');


// Utenti
Route::get('utenti_index', [UtentiController::class, 'index'])->name('utenti.index');
Route::get('utenti/{utente}', [UtentiController::class, 'edit'])->name('utenti.edit');
Route::get('utenti_create', [UtentiController::class, 'create'])->name('utenti.create');
Route::put('utenti/{utente}', [UtentiController::class, 'update'])->name('utenti.update');
Route::delete('utenti/{utente}', [UtentiController::class, 'destroy'])->name('utenti.destroy');
Route::post('utenti_store', [UtentiController::class, 'store'])->name('utenti.store');


// Collaboratori
Route::get('collaboratori', [CollaboratoriController::class, 'index'])->name('collaboratori.index');
Route::get('collaboratori/{collaboratore}', [CollaboratoriController::class, 'edit'])->name('collaboratori.edit');
Route::get('collaboratoriCreate', [CollaboratoriController::class, 'create'])->name('collaboratori.create');
Route::put('collaboratori/{collaboratore}', [CollaboratoriController::class, 'update'])->name('collaboratori.update');
Route::delete('collaboratori/{collaboratore}', [CollaboratoriController::class, 'destroy'])->name('collaboratori.destroy');
Route::post('collaboratori_store', [CollaboratoriController::class, 'store'])->name('collaboratori.store');


// Presenze
Route::get('presenze/{data}', [PresenzeController::class, 'indicePresenze'])->name('presenze.index');
Route::get('prendiDatiPresenza', [PresenzeController::class, 'prendiDatiPresenza']);
Route::delete('eliminaPresenza', [PresenzeController::class, 'destroy']);
Route::post('aggiorna_presenza', [PresenzeController::class, 'creaAggiornaPresenza'])->name('presenze.creaAggiornaPresenza');


// Ricevute
Route::get('ricevute', [RicevuteController::class, 'index'])->name('ricevute.index');

