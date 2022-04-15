<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'level' => 'required',
        ]);

        $utente->update($request->all());

        return redirect()->route('utenti.index');
    }

    public function destroy( User $utente)
    {
        $utente->delete();

        return redirect()->route('utenti.index');
    }

    public function create()
    {
        return view('utenti.store');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'level' => 'required',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level
        ]);

        return redirect()->route('utenti.index');
    }

}
