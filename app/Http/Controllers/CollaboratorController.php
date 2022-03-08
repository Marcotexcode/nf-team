<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaborator;


class CollaboratorController extends Controller
{
    public function index()
    {
        $collaborators = Collaborator::all();

        return view('collaborators.index', compact('collaborators'));
    }

    public function edit(Collaborator $collaborator)
    {
        return view('collaborators.edit', compact('collaborator'));
    }

    public function update(Request $request, Collaborator $collaborator)
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

        $collaborator->update($request->all());

        return redirect()->route('collaborators.index');
    }

    public function destroy( Collaborator $collaborator)
    {
        $collaborator->delete();

        return redirect()->route('collaborators.index');
    }

    public function create()
    {
        return view('collaborators.store');
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

        return redirect()->route('collaborators.index');

    }

}
