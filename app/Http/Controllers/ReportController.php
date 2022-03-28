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
        $collaboratori = Collaboratore::has('presenze')->get();

        foreach ($collaboratori as $collaboratore) {
            $totPresenze = Presenza::where('collaborator_id', $collaboratore->id)->where('tipo_di_presenza', 'Intera giornata')->count();
            $intereGiornate[$collaboratore->id] = $totPresenze;
        }
        foreach ($collaboratori as $collaboratore) {
            $totPresenze = Presenza::where('collaborator_id', $collaboratore->id)->where('tipo_di_presenza', 'Mezza giornata')->count();
            $mezzaGiornata[$collaboratore->id] = $totPresenze;
        }
        foreach ($collaboratori as $collaboratore) {
            $totPresenze = Presenza::where('collaborator_id', $collaboratore->id)->where('tipo_di_presenza', 'Giornata all\' estero')->count();
            $giornataEstero[$collaboratore->id] = $totPresenze;
        }
        foreach ($collaboratori as $collaboratore) {
            $totPresenze = Presenza::where('collaborator_id', $collaboratore->id)->where('tipo_di_presenza', 'Giornata di formazione propria')->count();
            $giornataFormazione[$collaboratore->id] = $totPresenze;
        }

        return view('stampe.report', compact('collaboratori', 'intereGiornate', 'mezzaGiornata', 'giornataEstero', 'giornataFormazione'));
    }
}
