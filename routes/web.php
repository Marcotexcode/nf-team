<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UtentiController;
use App\Http\Controllers\CollaboratorController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');


// Utenti
Route::get('user_index', [UtentiController::class, 'index'])->name('utenti.index');
Route::get('user/{utente}', [UtentiController::class, 'edit'])->name('utenti.edit');
Route::get('user_create', [UtentiController::class, 'create'])->name('utenti.create');
Route::put('user/{utente}', [UtentiController::class, 'update'])->name('utenti.update');
Route::delete('user/{utente}', [UtentiController::class, 'destroy'])->name('utenti.destroy');
Route::post('user/store', [UtentiController::class, 'store'])->name('utenti.store');


// Collaboratori
Route::get('collaborator', [CollaboratorController::class, 'index'])->name('collaborators.index');
Route::get('collaborator/{collaborator}', [CollaboratorController::class, 'edit'])->name('collaborators.edit');
Route::get('collaborator_create', [CollaboratorController::class, 'create'])->name('collaborators.create');
Route::put('collaborator/{collaborator}', [CollaboratorController::class, 'update'])->name('collaborators.update');
Route::delete('collaborator/{collaborator}', [CollaboratorController::class, 'destroy'])->name('collaborators.destroy');
Route::post('collaborator/store', [CollaboratorController::class, 'store'])->name('collaborators.store');
