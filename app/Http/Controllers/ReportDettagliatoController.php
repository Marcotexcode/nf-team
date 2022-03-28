<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportDettagliatoController extends Controller
{
    public function indiceReportDettagliato()
    {
        return view('stampe.report_dettagliato');
    }
}
