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

        // Inizializzo gli array
        $tipiDiPresenza = [];
        $giornataRimborso = [];
        $giornataBonus = [];
        $collaboratori = [];
        $importoGiornate = [];

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
                        'Giornata a prezzo concordato' => 0,
                    ];
                    $importoGiornate[$singolaPresenza->collaborator_id] = [
                        'Intera giornata' => 0,
                        'Mezza giornata' => 0,
                        'Giornata all\' estero' => 0,
                        'Giornata di formazione propria' => 0,
                        'Giornata a prezzo concordato' => 0,
                    ];
                }

                // Se è presente, incremento il suo valore
                $tipiDiPresenza[$singolaPresenza->collaborator_id][$singolaPresenza->tipo_di_presenza] += 1;
                $importoGiornate[$singolaPresenza->collaborator_id][$singolaPresenza->tipo_di_presenza] += $singolaPresenza->importo;

                $giornataRimborso[$singolaPresenza->collaborator_id][$singolaPresenza->spese_rimborso] = $singolaPresenza->spese_rimborso;
                $giornataBonus[$singolaPresenza->collaborator_id][$singolaPresenza->bonus] = $singolaPresenza->bonus;
            }
            //dd($tipiDiPresenza);
            // Prendo i collaboratori presenti nell' array tipiDiPresenza
            $collaboratori = Collaboratore::whereIn('id', array_keys($tipiDiPresenza))->get();
        }

        return view('stampe.report', compact('filtriDate', 'tipiDiPresenza', 'importoGiornate', 'giornataRimborso', 'giornataBonus', 'collaboratori'));
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

