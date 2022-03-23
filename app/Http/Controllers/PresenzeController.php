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
    public function index($data)
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

        $dataSuccessiva =  $data->copy()->addMonth()->year . '-' . $data->copy()->addMonth()->month;

        $dataPrecedente = $data->copy()->addMonth()->year . '-' . $data->copy()->subMonth()->month;

        $mesi[] = $data->englishMonth;
        $mesiNumero[] = $data->month;
        $giorni[] = $data->day;
        $anni[] = $data->year;

        return view('presenze.index', compact('collaboratori', 'arrPresenze', 'mesiNumero', 'mesi', 'giorni', 'data', 'dataSuccessiva', 'dataPrecedente', 'anni', 'presenze'));
    }

    public function creaAggiornaPresenza(Request $request)
    {
        $validazioni = Validator::make($request->all(), [
            'dataInizio' => 'required',
            'idColl' => 'required',
            'tipoPresenza' => 'required',
            'importo' => 'required',
            'luogo' => 'required',
        ]);

        $richieste = [
            'data' => $request->dataInizio,
            'collaborator_id' => $request->idColl,
            'tipo_di_presenza' => $request->tipoPresenza,
            'importo' => $request->importo,
            'luogo' => $request->luogo,
            'descrizione' => $request->descrizione,
            'spese_rimborso' => $request->speseRimborso,
            'bonus' => $request->bonus,
        ];

        if ($validazioni->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validazioni->messages()
            ]);
        }else {
            $idPresenza = Presenza::where('data', $request->dataInizio)->where('collaborator_id', $request->idColl)->value('id');

            if ($idPresenza) {
                $pres = Presenza::find($idPresenza)->update($richieste);

                return response()->json([
                    'status' => 200,
                    'message' => 'Modificato con successo',
                ]);

            } else {
                $pres = Presenza::create($richieste);

                return response()->json([
                    'status' => 200,
                    'message' => 'Aggiunto con successo',
                ]);
            }

        }

    }

    public function destroy(Request $request)
    {
        $idPresenza = Presenza::where('data', $request->dataInizio)->where('collaborator_id', $request->idColl)->value('id');

        Presenza::find($idPresenza)->delete();

        return response()->json();
    }

    public function prendiDatiPresenza(Request $request)
    {
        $presenzeSelezionate = 0;
        $presenzePresenti = Presenza::where('data', $request->dataSel)->where('collaborator_id', $request->idColl)->get();
        if (!$presenzePresenti->isEmpty()) {
            $presenzeSelezionate =  $presenzePresenti[0];
        } else {
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
        }

        return response()->json($presenzeSelezionate);
    }

}
