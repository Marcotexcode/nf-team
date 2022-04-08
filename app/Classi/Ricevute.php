<?php

namespace App\Classi;

use App\Models\Presenza;
use App\Models\Collaboratore;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Ricevute {

    public function ricevute()
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

        return [$collaboratori, $raccoltaPresenze, $totale, $data, $filtroMese];
    }

}
