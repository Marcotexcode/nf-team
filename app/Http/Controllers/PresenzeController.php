<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Models\Presenza;
use App\Models\Collaborator;


class PresenzeController extends Controller
{
    public function index($data)
    {
        //Carbon::setLocale('it');

        $collaboratori = Collaborator::all();

        $data = Carbon::createFromDate("$data"); //->locale('it');

        $dataNext = $data->copy()->addMonth();
        $dataSuccessiva =  $dataNext->year . '-' . $dataNext->month;

        $dataSub = $data->copy()->subMonth();
        $dataPrecedente = $dataSub->year . '-' . $dataSub->month;

        $mesi[] = $data->englishMonth;

        return view('presenze.index', compact('collaboratori', 'mesi', 'data', 'dataSuccessiva', 'dataPrecedente'));
    }


    public function create(Collaborator $collaboratore)
    {
        return view('presenze.index', compact('collaboratore'));
    }

    public function store(Request $request, $idCollaboratore)
    {
        dd($idCollaboratore);
        $presenza = new Presenza;

        $presenza->data_inizio = $request->data_inizio;
        $presenza->data_fine = $request->data_fine;
        $presenza->collaborator_id = //$collaboratore->id;
        $presenza->tipo_di_presenza = $request->tipo_di_presenza;
        $presenza->luogo = $request->luogo;
        $presenza->descrizione = $request->descrizione;
        $presenza->spese_rimborso = $request->spese_rimborso;
        $presenza->bonus = $request->bonus;

        $presenza->save();

        return redirect()->route('presenze.index');
    }

}
