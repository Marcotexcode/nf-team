<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presenza;
use App\Models\Collaboratore;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PDF;
//use Knp\Snappy\Pdf;


class RicevuteController extends Controller
{
    public function index()
    {
        // Inizializzo variabili e array
        $data = [
            'mese' => 0,
            'anno' => 0,
            'giorni' => 0
        ];

        $totale = [];


        // Prendo dati sessione
        $filtroMese = session('filtroMese');
        $filtroNome = session('filtroNome');


        $collaboratori = Collaboratore::query();

        // Se la sessione $filtroMese contiente  un dato, prendi mese e anno separati
        if ($filtroMese) {

            // Array chiave valore con mese anno giorni separati
            $data = [
                'mese' => Carbon::createFromFormat('Y-m', $filtroMese)->month,
                'anno' => Carbon::createFromFormat('Y-m', $filtroMese)->year,
                'giorni' => Carbon::createFromFormat('Y-m', $filtroMese)->daysInMonth
            ];

            // Prendo i collaboratori che hanno delle presenze che hanno come mese quelo richiesto
            $collaboratori = $collaboratori->whereHas('presenze', function (Builder $query) use($data) {
                $query->whereMonth('data', $data['mese'])->whereYear('data', $data['anno']);
            })->get();
        }

        // Se la sessione contiene filtroNome stampa solo i nomi richiesti
        if (session('filtroNome')) {
            $collaboratori = $collaboratori->where('nome', $filtroNome);
        }


        // Prendi solo le presenze che hanno il mese e l'anno richiesto
        $raccoltaPresenze = Presenza::whereMonth('data', $data['mese'])->whereYear('data', $data['anno'])->get();

        // Ciclo i collaboratori
        foreach ($collaboratori as $collaboratore) {

            // Prendo l'importo totale di ogni collaboratore
            $totaleImporto[$collaboratore->id] = $raccoltaPresenze->where('collaborator_id', $collaboratore->id)->sum('importo');

            // Prendo il rimborso totale di ogni collaboratore
            $totaleRimborso[$collaboratore->id] = $raccoltaPresenze->where('collaborator_id', $collaboratore->id)->sum('spese_rimborso');

            // Prendo il bonus totale di ogni collaboratore
            $totaleBonus[$collaboratore->id] = $raccoltaPresenze->where('collaborator_id', $collaboratore->id)->sum('bonus');

            // Sommo il totale dell' importo, rimborso, e bonus di ogni collaboratore
            $totale[$collaboratore->id] = $totaleImporto[$collaboratore->id] + $totaleRimborso[$collaboratore->id] + $totaleBonus[$collaboratore->id];
        }

        return view('stampe.ricevute', compact('collaboratori', 'raccoltaPresenze', 'totale', 'data', 'filtroMese'));
    }


    public function filtroMese(Request $request)
    {
        session()->put('filtroMese', $request->meseAnno);
        return redirect('ricevute');
    }

    public function filtroNome(Request $request)
    {
        session()->put('filtroNome', $request->filtroNome);
        return redirect('ricevute');
    }

    public function downloadPDF()
    {
        // Prendo dati sessione
        $filtroMese = session('filtro');
        $filtroNome = session('filtroNome');

        // Inizializzo variabili e array
        $mese = 0;
        $anno = 0;
        $giorni = 0;
        $totale = [];

        $collaboratori = Collaboratore::query();
        $nomeCollaboratori = Collaboratore::has('presenze')->get();

        // Se la sessione $filtroMese contiente  un dato, prendi mese e anno separati
        if (session('filtro')) {
            $mese = Carbon::createFromFormat('Y-m', $filtroMese['filtroMese'])->month;
            $anno = Carbon::createFromFormat('Y-m', $filtroMese['filtroMese'])->year;
            $giorni = Carbon::createFromFormat('Y-m', $filtroMese['filtroMese'])->daysInMonth;

            // Prendo i collaboratori che hanno delle presenze che hanno come mese quelo richiesto
            $collaboratori = $collaboratori->whereHas('presenze', function (Builder $query) use($mese, $anno) {
                $query->whereMonth('data', $mese)->whereYear('data', $anno);
            })->get();
        }

        // Se la sessione contiene filtroNome stampa solo i nomi richiesti
        if (session('filtroNome')) {
            $collaboratori = $collaboratori->where('nome', $filtroNome);
        }


        // Prendi solo le presenze che hanno il mese e l'anno richiesto
        $raccoltaPresenze = Presenza::whereMonth('data', $mese)->whereYear('data', $anno)->get();

        // Ciclo i collaboratori
        foreach ($collaboratori as $collaboratore) {
            // Prendo l'importo totale di ogni collaboratore
            $totaleImporto[$collaboratore->id] = $raccoltaPresenze->where('collaborator_id', $collaboratore->id)->sum('importo');
            // Prendo il rimborso totale di ogni collaboratore
            $totaleRimborso[$collaboratore->id] = $raccoltaPresenze->where('collaborator_id', $collaboratore->id)->sum('spese_rimborso');
            // Prendo il bonus totale di ogni collaboratore
            $totaleBonus[$collaboratore->id] = $raccoltaPresenze->where('collaborator_id', $collaboratore->id)->sum('bonus');

            // Sommo il totale dell' importo, rimborso, e bonus di ogni collaboratore
            $totale[$collaboratore->id] = $totaleImporto[$collaboratore->id] + $totaleRimborso[$collaboratore->id] + $totaleBonus[$collaboratore->id];
        }

        $ricevutePDF = PDF::loadView('stampe.ricevute', compact('collaboratori', 'raccoltaPresenze', 'totale', 'mese', 'anno', 'giorni', 'nomeCollaboratori', 'filtroMese'));
        // $ricevutePDF = new Pdf('/usr/local/bin/wkhtmltopdf.sh');
        // $ricevutePDF->setTimeout(5);
        return $ricevutePDF->download('ricevuta.pdf');

    }
}






























































// foreach ($raccoltaPresenze as $singolaPresenza) {
//     $dataGiornate[$singolaPresenza->collaborator_id][] =  $singolaPresenza->data;
//    // $importoGiornate[$singolaPresenza->collaborator_id][$singolaPresenza->tipo_di_presenza] += $singolaPresenza->importo;
//    // $dataGiornate[$singolaPresenza->collaborator_id] = $singolaPresenza->data;
// }
// $collaboratori = Collaboratore::whereIn('id', array_keys($dataGiornate))->get();





// $raccoltaPresenze = Presenza::whereMonth('data', $mese)->whereYear('data', $anno)->get();

// foreach ($raccoltaPresenze as $singolaPresenza) {
//     $dataPresenze[$singolaPresenza->collaborator_id][] = $singolaPresenza->data ;
// }




// $collaboratori = Collaboratore::whereHas('presenze', function (Builder $query) use($mese) {
//     $query->whereMonth('data', $mese)->whereYear('data', $anno);
// })->get();

// dd($collaboratori);







  //dd($raccoltaPresenze);

        // Inizializzo gli array
        // $dataPresenze = [];

        // foreach ($raccoltaPresenze as $singolaPresenza) {

        //     $dataPresenze[$singolaPresenza->collaborator_id] = $singolaPresenza->data ;

        // }
       /// dd($dataPresenze);


        //$raccoltaPresenze = Presenza::whereMonth('data', $mese)->whereYear('data', $anno)->get();










        // foreach ($raccoltaPresenze as $singolaPresenza) {
        //     $ImportoPresenze[$singolaPresenza->collaborator_id][$singolaPresenza->tipo_di_presenza] = $singolaPresenza->importo;
        //     $rimborsoPresenze[$singolaPresenza->collaborator_id][] = $singolaPresenza->spese_rimborso;
        //     $rimborsoPresenze[$singolaPresenza->collaborator_id][] = $singolaPresenza->bonus;

        //     $totImporto =  array_sum($ImportoPresenze[$singolaPresenza->collaborator_id]);
        //     $totRimborso =  array_sum($rimborsoPresenze[$singolaPresenza->collaborator_id]);
        //     $totBonus =  array_sum($rimborsoPresenze[$singolaPresenza->collaborator_id]);

        //     $totale[$singolaPresenza->collaborator_id] = $totImporto + $totRimborso +  $totBonus;

        // }











              // foreach ($collaboratori as $collaboratore) {
                //     $sommaImporto = Presenza::where('collaborator_id', $collaboratore->id)->pluck('importo')->toArray();
                //     $sommaRimborso = Presenza::where('collaborator_id', $collaboratore->id)->pluck('spese_rimborso')->toArray();
                //     $sommaBonus = Presenza::where('collaborator_id', $collaboratore->id)->pluck('bonus')->toArray();

                //     $tot = array_sum($sommaImporto) + array_sum($sommaRimborso) + array_sum($sommaBonus);

                //     $somme[$collaboratore->id] = $tot;
                // }













// $dataPresenze = [];
// $tipiDiPresenze = [];
// $importoPresenze = [];
// $collaboratori = [];



//  // Ciclo la collezione di presenze creata prima
//  foreach ($raccoltaPresenze as $singolaPresenza) {

//     // Se nell array multimediale non esiste come chiave l'id del collaboratore, inizzializza un array con i tipi di presenza
//     if (!array_key_exists($singolaPresenza->collaborator_id, $dataPresenze)) {

//         // Creo un array con tutti i tipi di presenze con valore zero
//         $arrTipiPresenze = [
//             'Intera giornata' => 0,
//             'Mezza giornata' => 0,
//             'Giornata all\' estero' => 0,
//             'Giornata di formazione propria' => 0,
//             'Giornata a prezzo concordato' => 0,
//         ];

//         // Inizializzo un array con le date delle presenze con valore 0
//         $dataPresenze[$singolaPresenza->collaborator_id] = $arrTipiPresenze;

//         // Inizializzo un array con i tipi di presenze con valore 0
//         $tipiDiPresenze[$singolaPresenza->collaborator_id] = $arrTipiPresenze;

//         // Inizializzo un array con l'importo delle presenze con valore 0
//         $importoPresenze[$singolaPresenza->collaborator_id] = $arrTipiPresenze;
//     }
//     // Do il giusto valore agli array inizializzati prima
//     $dataPresenze[$singolaPresenza->collaborator_id][$singolaPresenza->tipo_di_presenza] = $singolaPresenza->data;
//     $tipiDiPresenze[$singolaPresenza->collaborator_id][$singolaPresenza->tipo_di_presenza] = $singolaPresenza->tipo_di_presenza . ' (' . $singolaPresenza->luogo . ')';
//     $importoPresenze[$singolaPresenza->collaborator_id][$singolaPresenza->tipo_di_presenza] = $singolaPresenza->importo;




//     $date[$singolaPresenza->collaborator_id][$singolaPresenza->data] = $singolaPresenza->data;
//     $tipi[$singolaPresenza->collaborator_id][$singolaPresenza->data] = $singolaPresenza->tipo_di_presenza . ' (' . $singolaPresenza->luogo . ')';
//     $importo[$singolaPresenza->collaborator_id][$singolaPresenza->data] = $singolaPresenza->importo;
// }
// // dd($date);

// // Prendo solo i collaboratori che hanno come id la prima chiave dell' array $dataPresenze
// $collaboratori = Collaboratore::whereIn('id', array_keys($dataPresenze))->get();


// //$coll = Collaboratore::with('presenze')->get();

// // dd($coll);


// //$collaborat = Collaboratore::leftJoin('presenze', 'collaboratori.id', '=', 'presenze.collaborator_id')->select('data', 'importo')->whereMonth('data', $mese)->whereYear('data', $anno)->get();
// //$collaboratori = Presenza::join('collaboratori', 'presenze.collaborator_id' , '=', 'collaboratori.id')->whereMonth('data', $mese)->whereYear('data', $anno)->get();
// //dd($collaborat);
