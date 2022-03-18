<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Models\Presenza;
use App\Models\Collaborator;
use Illuminate\Support\Arr;

class PresenzeController extends Controller
{
    public function index($data)
    {
        $collaboratori = Collaborator::all();

        $presenze = Presenza::all();

        $data = Carbon::createFromDate("$data");

        // Marco ti scrivo tutti i passi da fare, ti metto i commenti tu scrivi il codice
        //
        // Prendere dalla tabella presenze tutti i record nel range di data che server (esempio: marzo 2022)
        // $presenze = ........
        // Ciclare ogni record trovato e usare la presenza per costruire un array che chiamiamo $arrPresenze[]
        // che ha due indici. Il primo indice è la data della presenza, il secondo indice è l'id del collaboratore;
        // il valore dell'array sarà l'intero record presenza che stai già ciclando.
        //
        // $arrPresenze = []
        // foreach ($presenze as $presenza) {
        //     QUI ASSEGNI $arrPresenze
        // }
        //
        //  Finito, è tutto qui.  $arrPresenze va passato al blade ovviamente


        $dataInizio = Carbon::createFromDate("$data")->startOfMonth();
        $dataFine = Carbon::createFromDate("$data")->lastOfMonth();

        $presenza = Presenza::whereBetween('data', [$dataInizio, $dataFine])->get();


       // dd($presenza);

        $arrPresenze = [];
        foreach ($presenza as $item) {
            $arrPresenze[$item->data][$item->collaborator_id] = $item;
        }

      // dd($arrPresenze);

        $dataNext = $data->copy()->addMonth();
        $dataSuccessiva =  $dataNext->year . '-' . $dataNext->month;


        $dataSub = $data->copy()->subMonth();
        $dataPrecedente = $dataSub->year . '-' . $dataSub->month;


        $mesi[] = $data->englishMonth;
        $mesiNumero[] = $data->month;
        $giorni[] = $data->day;
        $anni[] = $data->year;

        return view('presenze.index', compact('collaboratori', 'arrPresenze', 'mesiNumero', 'mesi', 'giorni', 'data', 'dataSuccessiva', 'dataPrecedente', 'anni', 'presenze'));
    }

    public function store(Request $request)
    {
        $oggi = Carbon::now();
        $data = $oggi->year . '-' . $oggi->month;

        $presenza = new Presenza;

        $presenza->data = $request->dataInizio;
        $presenza->collaborator_id = $request->idColl;
        $presenza->tipo_di_presenza = $request->tipoPresenza;
        $presenza->importo = $request->importo;
        $presenza->luogo = $request->luogo;
        $presenza->descrizione = $request->descrizione;
        $presenza->spese_rimborso = $request->speseRimborso;
        $presenza->bonus = $request->bonus;

        $presenza->save();

        return response()->json();
    }


    public function prendiDati(Request $request)
    {
        $idCollaboratore = $request->idColl;
        $dataSelezionata = $request->dataSel;
        $ciao = 10;
        $prendiDatiCollaboratore = Collaborator::where('id', $idCollaboratore)->get();

        $prendiDatiPresenze = Presenza::where('data', $dataSelezionata)->where('collaborator_id', $idCollaboratore)->get();

        return response()->json(array('prendiDatiCollaboratore' => $prendiDatiCollaboratore, 'prendiDatiPresenze' => $prendiDatiPresenze));
    }

}
