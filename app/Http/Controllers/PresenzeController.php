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


        // 1 - PROVA
        // $a = Collaborator::pluck('id')->toArray(); //a
        // $b = Presenza::pluck('data')->toArray(); //b

        // $presenza = [];

        // for ($i=0; $i < count($a); $i++) {
        //     $data = Presenza::where('collaborator_id', $a[$i] )->pluck('data')->toArray();
        //     for ($j=0; $j < count($data); $j++) {
        //         $array = array($data[$j] => $a[$i]);
        //         array_push($presenza, $array);
        //     }
        // }

        // dd($presenza);

        
        // Marco ti scrivo tutti i passi da fare, ti metto i commenti tu scrivi il codice
        // 
        // Prendere dalla tabella presenze tutti i record nel range di data che server (esempio: marzo 2022)
        // $presenze = ........
        // 
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
        // 
        
        // 2 - PROVA
        $a = Collaborator::pluck('id')->toArray(); //a
        $b = Presenza::pluck('data')->toArray(); //b

        $presenza = [];

        for ($i=0; $i < count($a); $i++) {
            $data = Presenza::where('collaborator_id', $a[$i] )->pluck('data')->toArray();
            for ($j=0; $j < count($data); $j++) {

                $valorePresenza = Presenza::where('collaborator_id', $a[$i])->where('data',$data[$j])->get();
                $presenza[$data[$j]][$a[$i]] = $valorePresenza;
            }
        }

        dd($presenza);


        //$presenza[$id][$data] = $presenze;


        $dataNext = $data->copy()->addMonth();
        $dataSuccessiva =  $dataNext->year . '-' . $dataNext->month;

        $dataSub = $data->copy()->subMonth();
        $dataPrecedente = $dataSub->year . '-' . $dataSub->month;

        $mesi[] = $data->englishMonth;
        $mesiNumero[] = $data->month;
        $giorni[] = $data->day;
        $anni[] = $data->year;

        return view('presenze.index', compact('collaboratori', 'mesiNumero', 'arrayPresenzeCollaboratori', 'mesi', 'giorni', 'data', 'dataSuccessiva', 'dataPrecedente', 'anni', 'presenze', 'idCollaboratore'));
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
