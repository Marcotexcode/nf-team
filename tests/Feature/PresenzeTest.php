<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Collaboratore;
use App\Models\Presenza;
use App\Models\User;

class PresenzeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_aggiunta_presenza()
    {
        $utente = User::factory()->create([ 'level' => '1']);

        $collaboratore = Collaboratore::factory()->create([
            'intera_giornata' => '10'
        ]);

        $dataInizio = "2022-04-01";
        $dataFine = "2022-04-05";

        $response = $this->actingAs($utente)->post(route('presenze.creaAggiornaPresenza'), [
            'data' => $dataInizio,
            'finoA' => $dataFine,
            'idColl'=> $collaboratore->id,
            'importo' => $collaboratore->intera_giornata,
            'tipoPresenza' => 'Intera giornata',
            'luogo'=> 'Roma',
            'descrizione' => 'Lorem',
            'speseRimborso' => '0.00',
            'bonus' => '5.00',
        ]);

        // Controllo che i dati salvati nel DB tramite la response sono giusti
        for ($i=$dataInizio; $i <= $dataFine; $i++) {
            $this->assertDatabaseHas('presenze', [
                'data' => $i,
                'collaborator_id'=> $collaboratore->id,
                'importo' => $collaboratore->intera_giornata,
                'tipo_di_presenza' => 'Intera giornata',
                'luogo'=> 'Roma',
                'descrizione' => 'Lorem',
                'spese_rimborso' => '0.00',
                'bonus' => '5.00',
            ]);
        }

        // Afferma che la risposta contiene i dati JSON forniti
        for ($i=$dataInizio; $i <= $dataFine; $i++) {
            $response->assertStatus(200)
            ->assertJsonFragment([
                'data' => $i,
                'collaborator_id'=> $collaboratore->id,
                'importo' => $collaboratore->intera_giornata,
                'tipo_di_presenza' => 'Intera giornata',
                'luogo'=> 'Roma',
                'descrizione' => 'Lorem',
                'spese_rimborso' => '0.00',
                'bonus' => '5.00',
            ]);
        }
        // Afferma che la struttura della risposta json sia giusta
        $response->assertJsonStructure([[ "data", ]]);


        // Un altro modo per vedere se la struttura e i dati sono uguali
        for ($i=$dataInizio; $i <= $dataFine; $i++) {
            $struttura[] = [
                'data' => $i,
                'collaborator_id'=> $collaboratore->id,
                'tipo_di_presenza' => 'Intera giornata',
                'importo' => $collaboratore->intera_giornata,
                'luogo'=> 'Roma',
                'descrizione' => 'Lorem',
                'spese_rimborso' => '0.00',
                'bonus' => '5.00',
            ];
        }


       $this->assertEquals(count($struttura), count($response->json()));

        //ciclo per prendere ogni chiave degli array interni
        for ($i=0; $i < count($struttura); $i++) {
            $this->assertTrue(array_diff_assoc($struttura[$i], array_splice($response->json()[$i], 0,8)) == [], 'Errore: chiave o valore non uguali');
        }

    }
}



