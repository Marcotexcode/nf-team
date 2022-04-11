<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classi\Ricevute;
use PDF;

class RicevuteController extends Controller
{
    public function index()
    {
        $ricevuta = new Ricevute;

        $ricevutaPresenze = $ricevuta->ricevute();
        $collaboratori = $ricevutaPresenze[0];
        $raccoltaPresenze = $ricevutaPresenze[1];
        $totale = $ricevutaPresenze[2];
        $data = $ricevutaPresenze[3];
        $filtroMese = $ricevutaPresenze[4];

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

        $ricevuta = new Ricevute;

        $ricevutaPresenze = $ricevuta->ricevute();
        $collaboratori = $ricevutaPresenze[0];
        $raccoltaPresenze = $ricevutaPresenze[1];
        $totale = $ricevutaPresenze[2];
        $data = $ricevutaPresenze[3];
        $filtroMese = $ricevutaPresenze[4];

        $pdf = PDF::loadView('stampe.ricevute', compact('collaboratori', 'raccoltaPresenze', 'totale', 'data', 'filtroMese'));

        return $pdf->download();
    }

}
