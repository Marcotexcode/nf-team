<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaboratore;
use App\Models\Presenza;



class CollaboratoriController extends Controller
{
    public function index()
    {
        $collaboratori = Collaboratore::all();

        return view('collaboratori.index', compact('collaboratori'));
    }

    public function edit(Collaboratore $collaboratore)
    {
        return view('collaboratori.edit', compact('collaboratore'));
    }

    public function update(Request $request, Collaboratore $collaboratore)
    {
        $request->validate ([
            'nome' => 'required',
            'cognome' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'citta' => 'required',
            'indirizzo' => 'required',
            'CAP' => 'required',
            'intera_giornata' => 'required',
            'mezza_giornata' => 'required',
            'giornata_estero' => 'required',
            'giornata_formazione' => 'required'
        ]);

        $collaboratore->update($request->all());

        return redirect()->route('collaboratori.index');
    }

    public function destroy( Collaboratore $collaboratore)
    {
        $collaboratore->delete();

        return redirect()->route('collaboratori.index');
    }

    public function create()
    {
        return view('collaboratori.store');
    }


    public function store(Request $request)
    {
        $request->validate ([
            'nome' => 'required',
            'cognome' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'citta' => 'required',
            'indirizzo' => 'required',
            'CAP' => 'required',
            'intera_giornata' => 'required',
            'mezza_giornata' => 'required',
            'giornata_estero' => 'required',
            'giornata_formazione' => 'required'
        ]);

        Collaboratore::create($request->all());

        return redirect()->route('collaboratori.index');
    }

}
