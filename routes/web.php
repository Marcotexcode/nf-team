<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UtentiController;

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
Route::view('utente', 'utenti.index')->name('utenti');
Route::get('utente', [UtentiController::class, 'index'])->name('utenti');
Route::get('utente/{utente}', [UtentiController::class, 'edit'])->name('utenti.edit');
Route::get('create', [UtentiController::class, 'create'])->name('utenti.create');
Route::put('utente/{utente}', [UtentiController::class, 'update'])->name('utenti.update');
Route::delete('utente/{utente}', [UtentiController::class, 'destroy'])->name('utenti.destroy');
Route::post('store', [UtentiController::class, 'store'])->name('utenti.store');


