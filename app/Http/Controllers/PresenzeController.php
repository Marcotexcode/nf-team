<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Models\Presenza;
use App\Models\Collaboratore;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class PresenzeController extends Controller
{
    public function indicePresenze($data)
    {
        $collaboratori = Collaboratore::all();

        $presenze = Presenza::all();

        $data = Carbon::createFromDate("$data");
        $dataInizio = Carbon::createFromDate("$data")->startOfMonth();
        $dataFine = Carbon::createFromDate("$data")->lastOfMonth();
        $datePresenze = Presenza::whereBetween('data', [$dataInizio, $dataFine])->get();

        $arrPresenze = [];
        foreach ($datePresenze as $dataPresenza) {
            $arrPresenze[$dataPresenza->data][$dataPresenza->collaborator_id] = $dataPresenza;
        }

        $dataSuccessiva = $data->copy()->addMonth()->year . '-' . $data->copy()->addMonth()->month;

        $dataPrecedente = $data->copy()->addMonth()->year . '-' . $data->copy()->subMonth()->month;

        $mesi[] = $data->englishMonth;
        $mesiNumero[] = $data->month;
        $giorni[] = $data->day;
        $anni[] = $data->year;

        return view('presenze.index', compact('collaboratori', 'arrPresenze', 'mesiNumero', 'mesi', 'giorni', 'data', 'dataSuccessiva', 'dataPrecedente', 'anni', 'presenze'));
    }

    public function datiPresenza(Request $request)
    {
        $presenzeSelezionate = 0;
        $presenzePresenti = Presenza::where('data', $request->dataSel)->where('collaborator_id', $request->idColl)->get();

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
            $presenzeSelezionate =  $presenzeNonPresenti;
        } else {
            $presenzeSelezionate =  $presenzePresenti[0];
        }

        return response()->json($presenzeSelezionate);
    }

    public function datiCollaboratore(Request $request)
    {
        $collaboratore = Collaboratore::where('id', $request->idColl)->select('intera_giornata', 'mezza_giornata', 'giornata_estero' , 'giornata_formazione')->get();

        $collaboratoreSelezionato = $collaboratore[0];

        return response()->json($collaboratoreSelezionato);
    }

    public function creaAggiornaPresenza(Request $request)
    {
        $validazioni = Validator::make($request->all(), [
            'data' => 'required',
            'idColl' => 'required',
            'tipoPresenza' => 'required',
            'importo' => 'required',
            'luogo' => 'required',
        ]);

        if ($validazioni->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validazioni->messages()
            ]);
        }

        $arrPresenzeCreate = [];

        for ($i=$request->data; $i <= $request->finoA; $i++) {

            $presenza =  Presenza::updateOrCreate(
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

        //dd($arrPresenzeCreate);

        return response()->json($presenza);
    }

    public function destroy(Request $request)
    {
        $idPresenza = Presenza::where('data', $request->prendiData)->where('collaborator_id', $request->prendiIdColl)->value('id');

        Presenza::find($idPresenza)->delete();

        return response()->json();
    }

}
