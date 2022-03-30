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

        // Prendo solo i collaboratori che hanno le presenze
        $collaboratori = Collaboratore::has('presenze')->get();

        // Ciclo ogni collaboratore che ha presenze
        foreach ($collaboratori as $collaboratore) {

            $pres = Presenza::where('collaborator_id', $collaboratore->id)->get();
            // Gli passo una chiave cosi poi può essere riperso facilmente nel blade
            // Prendo il numero totale di intere giornate che ha il collaboratore ciclato
            $intereGiornate[$collaboratore->id] = $pres->where('tipo_di_presenza', 'Intera giornata')->count();
            // Prendo il costo di intere giornate che ha il collaboratore ciclato
            $totSoldiInteraGiornata = Collaboratore::value('intera_giornata');
            // Calcolo il numero totale di intere giornate per il costo di intere giornate che ha il collaboratore ciclato
            $sommainteraGiornata[$collaboratore->id] = $totSoldiInteraGiornata * $intereGiornate[$collaboratore->id];


            $mezzaGiornata[$collaboratore->id] = $pres->where('tipo_di_presenza', 'Mezza giornata')->count();
            $totSoldiMezzaGiornata = Collaboratore::value('mezza_giornata');
            $sommaMezzaGiornata[$collaboratore->id] = $totSoldiMezzaGiornata * $mezzaGiornata[$collaboratore->id];

            $giornataEstero[$collaboratore->id] = Presenza::where('collaborator_id', $collaboratore->id)->where('tipo_di_presenza', 'Giornata all\' estero')->count();
            $totSoldiGiornataEstero = Collaboratore::value('giornata_estero');
            $sommaGiornataEstero[$collaboratore->id] = $totSoldiGiornataEstero * $giornataEstero[$collaboratore->id];

            $giornataFormazione[$collaboratore->id] = Presenza::where('collaborator_id', $collaboratore->id)->where('tipo_di_presenza', 'Giornata di formazione propria')->count();
            $totSoldiGiornataFormazione = Collaboratore::value('giornata_formazione');
            $sommaGiornataFormazione[$collaboratore->id] = $totSoldiGiornataFormazione * $giornataFormazione[$collaboratore->id];

            $giornataRimborso[$collaboratore->id] = Presenza::where('collaborator_id', $collaboratore->id)->pluck('spese_rimborso')->sum();

            $giornataBonus[$collaboratore->id] = Presenza::where('collaborator_id', $collaboratore->id)->pluck('bonus')->sum();

            $tot[$collaboratore->id] =  $sommainteraGiornata[$collaboratore->id] + $sommaMezzaGiornata[$collaboratore->id] + $sommaGiornataEstero[$collaboratore->id] + $sommaGiornataFormazione[$collaboratore->id] + $giornataRimborso[$collaboratore->id] + $giornataBonus[$collaboratore->id];
        }

        return view('stampe.report', compact('collaboratori', 'tot', 'filtriDate',  'intereGiornate', 'sommaGiornataFormazione', 'sommaMezzaGiornata', 'sommainteraGiornata', 'sommaGiornataEstero', 'mezzaGiornata', 'giornataEstero', 'giornataFormazione', 'giornataRimborso', 'giornataBonus'));
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





 //dd($filtriDate);

        // $totPresenzeIntere = 0;
        // $intereGiornate[] = 0;
        // $sommainteraGiornata[] = 0;

        // $totPresenzeMezze = 0;
        // $mezzaGiornata[] = 0;
        // $sommaMezzaGiornata[] = 0;

        // $pres = 0;
        // if(isset($filtriDate['dataIniziale'])) {
        //     $pres = Presenza::whereBetween('data', [$filtriDate['dataIniziale'], $filtriDate['dataFinale']]);

        //     foreach ($collaboratori as $collaboratore) {

        //         $totPresenzeIntere = $pres->where('collaborator_id', $collaboratore->id)->where('tipo_di_presenza', 'Intera giornata')->count();
        //         $intereGiornate[$collaboratore->id] = $totPresenzeIntere;
        //         $totSoldiInteraGiornata = Collaboratore::value('intera_giornata');
        //         $sommainteraGiornata[$collaboratore->id] = $totSoldiInteraGiornata * $totPresenzeIntere;

        //         $totPresenzeMezze = $pres->where('collaborator_id', $collaboratore->id)->where('tipo_di_presenza', 'Mezza giornata')->count();
        //         // dd($totPresenzeMezze);

        //         $mezzaGiornata[$collaboratore->id] = $totPresenzeMezze;
        //         $totSoldiMezzaGiornata = Collaboratore::value('mezza_giornata');
        //         $sommaMezzaGiornata[$collaboratore->id] = $totSoldiMezzaGiornata * $totPresenzeMezze;
        //     }
        // }
        //dd($intereGiornate);
