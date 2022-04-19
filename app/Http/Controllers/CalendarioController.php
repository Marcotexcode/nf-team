<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaboratore;
use Carbon\Carbon;


class CalendarioController extends Controller
{
    public function indiceCalendario($data)
    {
        $data = Carbon::createFromDate("$data");

        $collaboratori = Collaboratore::all();

        // Prendere il mese successivo della variabile data
        $dataSuccessiva = $data->copy()->addMonth()->year . '-' . $data->copy()->addMonth()->month;

        // Prendere il mese successivo della variabile data
        $dataPrecedente = $data->copy()->subMonth()->year . '-' . $data->copy()->subMonth()->month;

        $nomeMese = $data->locale('it')->monthName;
        $mesiNumero[] = $data->month;
        $anno = $data->year;

        return view('calendario.index', compact('data', 'mesiNumero', 'dataSuccessiva', 'dataPrecedente', 'collaboratori', 'nomeMese', 'anno'));
    }
}
