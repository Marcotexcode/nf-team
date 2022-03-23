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

        $coll = Collaboratore::get();

        // Per ogni collaboratore devo fare la somma totale dell' importo, rimborso e bonus
        $somme = [];

        foreach ($coll as $value) {
            $sommaImporto = Presenza::where('collaborator_id', $value->id)->pluck('importo')->toArray();
            $sommaRimborso = Presenza::where('collaborator_id', $value->id)->pluck('spese_rimborso')->toArray();
            $sommaBonus = Presenza::where('collaborator_id', $value->id)->pluck('bonus')->toArray();

            $tot = array_sum($sommaImporto) + array_sum($sommaRimborso) + array_sum($sommaBonus);
            array_push($somme, $tot);
        }

        //$pro = Collaboratore::has('presenze')->get();

        return view('stampe.ricevute', compact('collaboratori', 'somme'));
    }
}
