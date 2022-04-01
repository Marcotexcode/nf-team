<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presenza;
use App\Models\Collaboratore;
use Illuminate\Database\Eloquent\Builder;

class ReportController extends Controller
{
    public function indiceReport()
    {
        $filtriDate = session('filtriDate');

        // Inizializzo un array
        $tipiDiPresenza = [];
        $giornataRimborso = [];
        $giornataBonus = [];
        $collaboratori = [];

        if(session('filtriDate')) {

            // Creo una collezione di presenze che hanno un range di data richiesto
            $raccoltaPresenze = Presenza::whereBetween('data', [$filtriDate['dataIniziale'], $filtriDate['dataFinale']])->get();

            // Ciclo la collezione cerata prima
            foreach ($raccoltaPresenze as $singolaPresenza) {
                // Controllo se nell' array tipiDiPresenza è presente l'id del collaboratore
                if (!array_key_exists($singolaPresenza->collaborator_id, $tipiDiPresenza)) {
                    // Se non è presente lo inizializzo
                    $tipiDiPresenza[$singolaPresenza->collaborator_id] = [
                        'Intera giornata' => 0,
                        'Mezza giornata' => 0,
                        'Giornata all\' estero' => 0,
                        'Giornata di formazione propria' => 0,
                    ];
                }
                // Se è presente, incremento il suo valore
                $tipiDiPresenza[$singolaPresenza->collaborator_id][$singolaPresenza->tipo_di_presenza] += 1;

                $giornataRimborso[$singolaPresenza->collaborator_id][$singolaPresenza->spese_rimborso] = $singolaPresenza->spese_rimborso;
                $giornataBonus[$singolaPresenza->collaborator_id][$singolaPresenza->bonus] = $singolaPresenza->bonus;
            }
            // Prendo i collaboratori presenti nell' array tipiDiPresenza
            $collaboratori = Collaboratore::whereIn('id', array_keys($tipiDiPresenza))->get();
        }

        return view('stampe.report', compact('filtriDate', 'tipiDiPresenza', 'giornataRimborso', 'giornataBonus', 'collaboratori'));
    }

    public function filtroDate(Request $request)
    {


        $datiRicerca = [
            'dataIniziale' => $request->dataIniziale,
            'dataFinale' => $request->dataFinale,
        ];

        session()->put('filtriDate', $datiRicerca);

        return redirect('report');
    }

}





















































































                //$giornataRimborso[$singolaPresenza->collaborator_id] = $raccoltaPresenze->pluck('spese_rimborso')->sum();
               // dd($giornataRimborso);




  // if (array_column($p, $raccoltaPresenza->tipo_di_presenza)) {
                //     $p[$raccoltaPresenza->collaborator_id][$raccoltaPresenza->tipo_di_presenza] += 1;
                // }
                // Creo un array multidimensionale in  cui inserisco come prima chiave l'id del collaboratore
                // come seconda chiave il tipo di presenza
                // e come valore 1 che verrà incrementato se la seconda chiave e uguale al valore confrontato
                // if (array_column($p, $raccoltaPresenza->tipo_di_presenza)) {
                //     $p[$raccoltaPresenza->collaborator_id][$raccoltaPresenza->tipo_di_presenza] += 1;
                // } else {
                //     $p[$raccoltaPresenza->collaborator_id][$raccoltaPresenza->tipo_di_presenza] =  1;
                // }
               // dd(array_keys ( $p , $raccoltaPresenza->tipo_di_presenza));


// Prendo solo i collaboratori che hanno le presenze

        // FIXME: prendere solo i collaboratori che hanno le presenze nel range di date che mi servono solo in un certo periodo di tempo:
        // esempio perndere solo le presenze che partono dal 01/03/2022 al 10/03/2022

        // Creo una variabile, e come valore gli do la collezione (raccolta) di collaboratori, che hanno delle presenze
        // che hanno come data: dall' '01/03/2022' all' '10/03/2022'.
        // $dataRangePresenzeCollaboratori = Collaboratore::whereHas('presenze', function (Builder $query) {
        //     $query->whereBetween('data', ['2022-03-01', '2022-03-10']);
        // })->get();




        // // // //  // FIXME: invece di usare 12 variabili diverse mettere tutto in un array multidimensionale
        // // // // // FIXME: fare una sola query per ogni presenza senza ciclare per ogni collaboratore e aggiungere i risultati  in un array multidimensionale

        // // // // // Fare solamente due query, una per i collaboratori e una per le presenze
        // // // // // I risultati delle due query unirli in un array multidimensionale




         // Ciclo con uacondizione

        // Devo fare solo due query una per le presenze e una per i collaboratori
        // Devo prendere il totale di tipo di presenza per ogni collaboratore senza fare un altra query
        // Devo collegare il risultato del numero totale di ogni tipo di presenza al suo collaboratore

        // Come faccio a prendere il totale di tipo di presenza per ogni collaboratore senza fare una query?
        // ...
        // La moltiplicazione la posso fare direttamente nel blade


                        // Se la seconda chiave dell array corrisponde a $raccoltaPresenza->tipo_di_presenza
                // if($p[$raccoltaPresenza->collaborator_id][$raccoltaPresenza->tipo_di_presenza] ==  $raccoltaPresenza->tipo_di_presenza) {
                //     $p[$raccoltaPresenza->collaborator_id][$raccoltaPresenza->tipo_di_presenza] = +;
                // } else {
                //     $p[$raccoltaPresenza->collaborator_id][$raccoltaPresenza->tipo_di_presenza] =  1;
                // }







                  // // Raccolta persenze as singola presenza
            // // Ciclo la collezione di presenze create in precedenza per estrarre i dati che mi servono e come valore gli do il tipo di presenza (che cambierò dopo)
            // foreach ($raccoltaPresenze as $raccoltaPresenza) {
            //     $tipiDiPresenza[$raccoltaPresenza->collaborator_id][$raccoltaPresenza->tipo_di_presenza] =  $raccoltaPresenza->tipo_di_presenza;
            // }

            // // dd($tipiDiPresenza);

            // // Faccio un altro ciclo per controllare il valore cambiare il valore
            // foreach ($raccoltaPresenze as $raccoltaPresenza) {

            //     //dd($raccoltaPresenza);
            //     // Quando il valore dell'array multidimensionale è uguale al ciclo $raccoltaPresenza->tipo_di_presenza
            //     // aggiungi 1 al valore
            //     if($tipiDiPresenza[$raccoltaPresenza->collaborator_id][$raccoltaPresenza->tipo_di_presenza] ==  $raccoltaPresenza->tipo_di_presenza) {
            //         $tipiDiPresenza[$raccoltaPresenza->collaborator_id][$raccoltaPresenza->tipo_di_presenza] = 1;
            //     // Quando non è uguale incrementa il valore
            //     } else {
            //         $tipiDiPresenza[$raccoltaPresenza->collaborator_id][$raccoltaPresenza->tipo_di_presenza] += 1;
            //     }
            // }









                // Inizializzo gli array che mi serviranno dopo
        // $intereGiornate = [];
        // $sommainteraGiornata = [];

        // $mezzaGiornata = [];
        // $sommaMezzaGiornata = [];

        // $giornataEstero = [];
        // $sommaGiornataEstero = [];

        // $giornataFormazione = [];
        // $sommaGiornataFormazione = [];

        // $prezzoConcordato = [];
        // $sommaPrezzoConcordato = [];


        // $giornataRimborso = [];

        // $giornataBonus = [];

        // $tot = [];

        // $presenzeFiltrate = 0;




        // if(session('filtriDate')) {

        //     // Ciclo ogni collaboratore che ha presenze
        //     foreach ($collaboratori as $collaboratore) {
        //     // FIXME: invece di usare 12 variabili diverse mettere tutto in un array multidimensionale
        //     // FIXME: fare una sola query per ogni presenza senza ciclare per ogni collaboratore e aggiungere i risultati  in un array multidimensionale


        //         //  Prendo una collezione di record che stanno in un certo range e hanno l'id del collaboratore presente nel ciclo
        //         $presenzeCollaboratori = Presenza::whereBetween('data', [$filtriDate['dataIniziale'], $filtriDate['dataFinale']])->where('collaborator_id', $collaboratore->id)->get();

        //         // In un array con chiave l'id del collaboratore che sta nel ciclo gli do come valore il numero totale delle intere giornate
        //         // presenti nella collezione creata prima
        //         $intereGiornate[$collaboratore->id] = $presenzeCollaboratori->where('tipo_di_presenza', 'Intera giornata')->count();

        //         // In un array con chiave l'id del collaboratore che sta nel ciclo gli do come valore il costo
        //         // dell' intera giornata dell' collaboratore ciclato, moltiplicato per il numero totale delle intere giornate
        //         $sommainteraGiornata[$collaboratore->id] = $collaboratore->intera_giornata * $intereGiornate[$collaboratore->id];


        //         $mezzaGiornata[$collaboratore->id] = $presenzeCollaboratori->where('tipo_di_presenza', 'Mezza giornata')->count();
        //         $sommaMezzaGiornata[$collaboratore->id] = $collaboratore->mezza_giornata * $mezzaGiornata[$collaboratore->id];


        //         $giornataEstero[$collaboratore->id] = $presenzeCollaboratori->where('tipo_di_presenza', 'Giornata all\' estero')->count();
        //         $sommaGiornataEstero[$collaboratore->id] = $collaboratore->giornata_estero * $giornataEstero[$collaboratore->id];


        //         $giornataFormazione[$collaboratore->id] = $presenzeCollaboratori->where('tipo_di_presenza', 'Giornata di formazione propria')->count();
        //         $sommaGiornataFormazione[$collaboratore->id] = $collaboratore->giornata_formazione * $giornataFormazione[$collaboratore->id];


        //         //$prezzoConcordato[$collaboratore->id] = $presenzeCollaboratori->where('tipo_di_presenza', 'Giornata a prezzo concordato')->count();
        //        // $sommaGiornataFormazione[$collaboratore->id] = $collaboratore->giornata_formazione * $prezzoConcordato[$collaboratore->id];

        //        // dd($prezzoConcordato[$collaboratore->id]);

        //         $giornataRimborso[$collaboratore->id] = $presenzeCollaboratori->pluck('spese_rimborso')->sum();

        //         $giornataBonus[$collaboratore->id] = $presenzeCollaboratori->pluck('bonus')->sum();

        //         $tot[$collaboratore->id] =  $sommainteraGiornata[$collaboratore->id] + $sommaMezzaGiornata[$collaboratore->id] + $sommaGiornataEstero[$collaboratore->id] + $sommaGiornataFormazione[$collaboratore->id] + $giornataRimborso[$collaboratore->id] + $giornataBonus[$collaboratore->id];
        //     }
        // }
