<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UtentiController extends Controller
{
    public function index()
    {
        $utenti = User::all();

        return view('utenti.index', compact('utenti'));
    }

    public function edit(User $utente)
    {
        return view('utenti.edit', compact('utente'));
    }

    public function update(Request $request, User $utente)
    {
        $utente->update($request->all());

        return redirect()->route('utenti');
    }

    public function destroy( User $utente)
    {
        $utente->delete();

        return redirect()->route('utenti');
    }

    public function create()
    {
        return view('utenti.store');
    }

    public function store(Request $request)
    {
        User::create($request->all());

        return redirect()->route('utenti');

    }

}
