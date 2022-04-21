<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaboratore;
use App\Models\Presenza;

use Carbon\Carbon;


class CalendarioController extends Controller
{
    public function indiceCalendario($data)
    {
        $data = Carbon::createFromDate("$data");
        $dataInizio = Carbon::createFromDate("$data")->startOfMonth();
        $dataFine = Carbon::createFromDate("$data")->lastOfMonth();

        $collaboratori = Collaboratore::all();

        // Prendere il mese successivo della variabile data
        $dataSuccessiva = $data->copy()->addMonth()->year . '-' . $data->copy()->addMonth()->month;

        // Prendere il mese successivo della variabile data
        $dataPrecedente = $data->copy()->subMonth()->year . '-' . $data->copy()->subMonth()->month;

        $nomeMese = $data->locale('it')->monthName;
        $mesiNumero[] = $data->month;
        $anno = $data->year;

        // prendo solo le presenzez del mese corrente
        $arrPresenze = [];
        $datePresenze = Presenza::whereBetween('data', [$dataInizio, $dataFine])->get();
        foreach ($datePresenze as $dataPresenza) {
            $arrPresenze[$dataPresenza->data][$dataPresenza->collaborator_id] = $dataPresenza;
        }

        return view('calendario.index', compact('data', 'arrPresenze', 'mesiNumero', 'dataSuccessiva', 'dataPrecedente', 'collaboratori', 'nomeMese', 'anno'));
    }

    public function datiCollaboratore(Request $request)
    {
        $collaboratore = Collaboratore::where('id', $request->idCollaboratore)->select('intera_giornata', 'mezza_giornata', 'giornata_estero' , 'giornata_formazione')->get();

        $collaboratoreSelezionato = $collaboratore[0];

        return response()->json($collaboratoreSelezionato);
    }

    public function datiPresenze(Request $request)
    {

        $presenzeSelezionate = 0;
        $presenzePresenti = Presenza::where('data', $request->dataPresenza)->where('collaborator_id', $request->idCollaboratore)->get();

        if ($presenzePresenti->isEmpty()) {
            $presenzeNonPresenti = collect([
                "id" => "",
                "data" => "",
                "collaborator_id" => "",
                "importo" => "",
                "tipo_di_presenza" => "",
                "luogo" => "",
                "descrizione" => "",
                "spese_rimborso" => "",
                "bonus" => "",
                "created_at" => "",
                "updated_at" => "",
            ]);
            $presenzeSelezionate = $presenzeNonPresenti;
        } else {
            $presenzeSelezionate = $presenzePresenti[0];
        }

        return response()->json($presenzeSelezionate);
    }

    public function creaAggiorna(Request $request)
    {
        $arrPresenzeCreate = [];

        for ($i=$request->data; $i <= $request->finoA; $i++) {
            $presenza = Presenza::updateOrCreate(
                [
                    'data' => $i, 'collaborator_id' => $request->idColl
                ],
                [
                    'data' => $i,
                    'collaborator_id' => $request->idColl,
                    'tipo_di_presenza' => $request->tipoPresenza,
                    'importo' => $request->importo,
                    'luogo' => $request->luogo,
                    'descrizione' => $request->descrizione,
                    'spese_rimborso' => $request->speseRimborso,
                    'bonus' => $request->bonus,
                ]
            );
            array_push($arrPresenzeCreate, $presenza);
        }

        return response()->json($arrPresenzeCreate);
    }
}
