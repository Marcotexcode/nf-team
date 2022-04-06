<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Presenza extends Model
{
    use HasFactory;

    protected $table = 'presenze';

    protected $fillable = [
        'data',
        'collaborator_id',
        'importo',
        'tipo_di_presenza',
        'luogo',
        'descrizione',
        'spese_rimborso',
        'bonus',
    ];

    public function collaboratori()
    {
        return $this->belongsTo(Collaboratore::class, 'collaborator_id', 'id');
    }

    public function numeroPresenze($presenza)
    {
        // Inizializzo gli array
        $tipiDiPresenza = [];

        // Ciclo la collezione cerata prima
        foreach ($presenza as $singolaPresenza) {
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
            }
            // Se è presente, incremento il suo valore
            $tipiDiPresenza[$singolaPresenza->collaborator_id][$singolaPresenza->tipo_di_presenza] += 1;
        }

        return $tipiDiPresenza;
    }

    public function importoPresenze($presenza)
    {
        // Inizializzo gli array
        $tipiDiPresenza = [];


        // Ciclo la collezione cerata prima
        foreach ($presenza as $singolaPresenza) {
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
            }
            // Se è presente, incremento il suo valore
            $tipiDiPresenza[$singolaPresenza->collaborator_id][$singolaPresenza->tipo_di_presenza] += $singolaPresenza->importo;

        }

        return $tipiDiPresenza;
    }

    public function rimborsoPresenze($presenza)
    {
        // Inizializzo gli array
        $giornataRimborso = [];

        // Ciclo la collezione cerata prima
        foreach ($presenza as $singolaPresenza) {
            $giornataRimborso[$singolaPresenza->collaborator_id][$singolaPresenza->spese_rimborso] = $singolaPresenza->spese_rimborso;
        }

        return $giornataRimborso;
    }

    public function bonusPresenze($presenza)
    {
        // Inizializzo gli array
        $giornataBonus = [];

        // Ciclo la collezione cerata prima
        foreach ($presenza as $singolaPresenza) {
            $giornataBonus[$singolaPresenza->collaborator_id][$singolaPresenza->bonus] = $singolaPresenza->bonus;
        }

        return $giornataBonus;
    }

}
