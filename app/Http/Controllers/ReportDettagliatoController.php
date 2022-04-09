<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presenza;
use Carbon\Carbon;

class ReportDettagliatoController extends Controller
{
    public function indiceReportDettagliato()
    {
        /* Prendo dati in sessione */
        $filtroMese = session('filtroMese');

        /* Inizializzo variabili e array */
        $mese = 0;
        $anno = 0;
        $meseTesto = 'nessuno';

        /* Creo una condizione che se in sessione c'è un dato allora dividimi il mese e l'anno
         * in due variabili */
        if ($filtroMese) {
            $mese = Carbon::createFromFormat('Y-m', $filtroMese)->month;
            $anno = Carbon::createFromFormat('Y-m', $filtroMese)->year;
            /* Passare il mese non come numero ma come testo e in italiano */
            $meseTesto = Carbon::createFromFormat('Y-m', $filtroMese)->locale('it')->monthName;
        }


        /* Passo solo le presenze con i collaboratori, che hanno il mese e l'anno richiesti  */
        $presenze = Presenza::with('collaboratori')->whereMonth('data', $mese)->whereYear('data', $anno)->get();

        return view('stampe.report_dettagliato', compact('presenze', 'filtroMese', 'meseTesto'));
    }

    public function filtroReportDettagliato(Request $request)
    {
        session()->put('filtroMese', $request->meseAnno);

        return redirect('report_dettagliato');
    }

}
