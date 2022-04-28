<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfiloController extends Controller
{
    public function index()
    {
        $profilo = Auth::user();

        return view('profilo.profiloUtente', compact('profilo'));
    }

    public function update(Request $request, User $utente)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'level' => 'required',
        ]);

        $utente->where('id', Auth::user()->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level,
        ]);

        return redirect()->route('home');
    }

    public function destroy(User $utente)
    {
        if ($utente->where('level', 1)->where('id', '!=', Auth::user()->id)->count() == 1) {
            $utente->where('id', Auth::user()->id)->delete();
        }

        return redirect()->route('home');
    }
}
