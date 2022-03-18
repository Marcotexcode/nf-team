<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaborator;
use App\Models\Presenza;



class CollaboratoriController extends Controller
{
    public function index()
    {
        $collaboratori = Collaborator::all();

        dd($prendiDatiCollaboratore);


        return view('collaboratori.index', compact('collaboratori'));
    }

    public function edit(Collaborator $collaboratore)
    {
        return view('collaboratori.edit', compact('collaboratore'));
    }

    public function update(Request $request, Collaborator $collaboratore)
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

    public function destroy( Collaborator $collaboratore)
    {
        $collaboratore->delete();

        return redirect()->route('collaboratori.index');
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

        Collaborator::create($request->all());

        return redirect()->route('collaboratori.index');
    }

}