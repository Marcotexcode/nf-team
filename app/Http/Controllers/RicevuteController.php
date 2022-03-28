<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presenza;
use App\Models\Collaboratore;


class RicevuteController extends Controller
{
    public function index()
    {
        $collaboratori = Collaboratore::all();


        foreach ($collaboratori as $collaboratore) {
            $sommaImporto = Presenza::where('collaborator_id', $collaboratore->id)->pluck('importo')->toArray();
            $sommaRimborso = Presenza::where('collaborator_id', $collaboratore->id)->pluck('spese_rimborso')->toArray();
            $sommaBonus = Presenza::where('collaborator_id', $collaboratore->id)->pluck('bonus')->toArray();

            $tot = array_sum($sommaImporto) + array_sum($sommaRimborso) + array_sum($sommaBonus);

            $somme[$collaboratore->id] = $tot;
            //dd($somme);
        }
        return view('stampe.ricevute', compact('collaboratori', 'somme'));
    }
}
