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
            // Controllo se le chiavi e i valori degli array sono uguali
            if(array_diff_assoc($struttura[$i], array_splice($response->json()[$i], 0,8)) == []) {

                $assertvalue = true;
            } else {
                $assertvalue = false;
            }
            $this->assertTrue($assertvalue, 'Chiave o valore non uguale');
        }

    }
}










 // Confronto i due array, e vedo se hanno all'interno lo stesso numero di array
        // if (count($struttura) == count($response->json())) {

        //     for ($i=0; $i < count($struttura[0]); $i++) {
        //         dd(array_slice($struttura[0], $i, 1,));

        //         for ($j=0; $j < count($struttura[0]); $j++) {

        //             if (in_array(array_slice($struttura[0], $i, 1), $response->json()[0])) {

        //                 dd('funziona');

        //             } else {

        //                 dd('non funziona');

        //             }
        //         }
        //     }
        // }









// Confronto i due array, e vedo se hanno all'interno lo stesso numero di array
// if (count($struttura) == count($response->json())) {
//     //ciclo per prendere ogni chiave degli array interni
//     for ($i=0; $i < count($struttura); $i++) {

//         // Controllo se le chiavi e i valori degli array sono uguali
//         if(array_diff_assoc($struttura[$i], array_splice($response->json()[$i], 0,8)) == []) {

//             dd('Funziona');

//         } else {

//             dd('non funziona');

//         }
//     }
//     } else {
//     dd('non funziona numero');
// }














































// $arrayChiavi = array_keys($struttura[0]);






   // Controllo se il numero degli array interni sono uguali
// //    if (count($struttura[$i]) == count($arrayDiRispostaPulito)) {

// //     dd('Funziona');

// // } else {

// //     dd('errore count  array interni');

// }






































 // Prendo tutte le chiavi dell array $struttura
       // $arrayChiaviStruttura = array_keys($struttura[0]);
    //    $arrayChiaviRisposta = array_keys($response->json()[0]);

        //array_splice($response->json()[0], 'updated_at', 'created_at', 'id');

       // dd($arrayChiavi);

       // dd($response->json()[0]);


 // Ciclo l'array di chiavi
//  for ($i=0; $i <= count($arrayChiaviStruttura); $i++) {

//     for ($j=0; $j <= count($response->json()[0]); $j++) {

//         /*
//          * prendo ogni singolo elemento dell array di chiavi,
//          * e vedo se si trova nell' array di risposta json
//         */
//         if ($arrayChiaviStruttura[$i] == $arrayChiaviRisposta[$j]) {
//            array_push($a, 'esiste');
//         } else {
//            array_push($a, 'non esiste');
//         }
//     }

// }
// dd($a);


 // in_array($arrayChiavi[$i], $response->json()[0]);

        //$result = array_diff_key($struttura, $response->json());

       // dd(array_diff_key($struttura, $response->json()));

        // if (array_diff_assoc($struttura, $response->json())) {
        //     dd('funziona');
        // } else {
        //     dd('non funzinoa');
        // }

        // $response->assertContains($struttura, $response->json());
        //dd($response->json());






 //dd($response->json());

//  for ($i=$dataInizio; $i <= $dataFine; $i++) {
//     $struttura[] = [
//         "data" => $i,
//         "collaborator_id" => $collaboratore->id,
//         "tipo_di_presenza" => "Intera giornata",
//         "importo" => $collaboratore->intera_giornata,
//         "luogo" => "Roma",
//         "descrizione" => "Lorem",
//         "spese_rimborso" => "0.00",
//         "bonus" => "5.00",
//         "updated_at" => "2022-04-14T13:44:41.000000Z",
//         "created_at" => "2022-04-14T13:44:41.000000Z",
//         "id" => 1,
//     ];
// }

// dd($struttura);

//$response->json();



// // // // $arrayChiavi = [
// // // //     "data",
// // // //     "collaborator_id",
// // // //     "tipo_di_presenza",
// // // //     "importo",
// // // //     "luogo",
// // // //     "descrizione",
// // // //     "spese_rimborso",
// // // //     "bonus",
// // // //     "updated_at",
// // // //     "created_at",
// // // //     "id",
// // // // ];









































//$response->json();

// Trasforma l'oggetto $response in risposta json e poi decodifica il json in array
//$arrayRisposta = json_decode(json_encode($response), true);


// $data = [
//     'data' => $dataInizio,
//     'finoA' => $dataFine,
//     'idColl'=> $collaboratore->id,
//     'importo' => $collaboratore->intera_giornata,
//     'tipoPresenza' => 'Intera giornata',
//     'luogo'=> 'Roma',
//     'descrizione' => 'Lorem',
//     'speseRimborso' => '0.00',
//     'bonus' => '5.00',
// ];


// [
//     0 =>  [
//       "data" => "2022-04-01",
//       "collaborator_id" => 1,
//       "tipo_di_presenza" => "Intera giornata",
//       "importo" => 6,
//       "luogo" => "Roma",
//       "descrizione" => "Lorem",
//       "spese_rimborso" => "0.00",
//       "bonus" => "5.00",
//       "updated_at" => "2022-04-14T09:18:51.000000Z",
//       "created_at" => "2022-04-14T09:18:51.000000Z",
//       "id" => 1
//     ],
//     1 =>  [
//       "data" => "2022-04-02",
//       "collaborator_id" => 1,
//       "tipo_di_presenza" => "Intera giornata",
//       "importo" => 6,
//       "luogo" => "Roma",
//       "descrizione" => "Lorem",
//       "spese_rimborso" => "0.00",
//       "bonus" => "5.00",
//       "updated_at" => "2022-04-14T09:18:51.000000Z",
//       "created_at" => "2022-04-14T09:18:51.000000Z",
//       "id" => 2,
//     ],
//     2 =>  [
//       "data" => "2022-04-03",
//       "collaborator_id" => 1,
//       "tipo_di_presenza" => "Intera giornata",
//       "importo" => 6,
//       "luogo" => "Roma",
//       "descrizione" => "Lorem",
//       "spese_rimborso" => "0.00",
//       "bonus" => "5.00",
//       "updated_at" => "2022-04-14T09:18:51.000000Z",
//       "created_at" => "2022-04-14T09:18:51.000000Z",
//       "id" => 3
//     ],
//     3 =>  [
//       "data" => "2022-04-04",
//       "collaborator_id" => 1,
//       "tipo_di_presenza" => "Intera giornata",
//       "importo" => 6,
//       "luogo" => "Roma",
//       "descrizione" => "Lorem",
//       "spese_rimborso" => "0.00",
//       "bonus" => "5.00",
//       "updated_at" => "2022-04-14T09:18:51.000000Z",
//       "created_at" => "2022-04-14T09:18:51.000000Z",
//       "id" => 4
//     ],
//     4 =>  [
//       "data" => "2022-04-05",
//       "collaborator_id" => 1,
//       "tipo_di_presenza" => "Intera giornata",
//       "importo" => 6,
//       "luogo" => "Roma",
//       "descrizione" => "Lorem",
//       "spese_rimborso" => "0.00",
//       "bonus" => "5.00",
//       "updated_at" => "2022-04-14T09:18:51.000000Z",
//       "created_at" => "2022-04-14T09:18:51.000000Z",
//       "id" => 5
//     ]
//   ]



//dd($response->decodeResponseJson());
        //dd(get_class($response));
        //dd($response->json());








// $response
// ->assertStatus(200)
// ->assertJson([
//     'created' => true,
// ]);

//$response->assertStatus(200);

















        // $response->assertStatus(200)
        //     ->assertJson([
        //         'created' => true,
        //     ]);

        //$response->assertStatus(200)->dd();






/* Controllo se il record e stato creato */
// $this->assertDatabaseHas('presenze', [
//     'data' => '1976-11-19',
// ]);


//$utente = User::factory()->create([ 'level' => '1']);

// $presenza = Presenza::factory()->create([
//     'collaborator_id' => $collaboratore->id,
// ]);



// $presenza = $this->actingAs($utente)->post(route('presenze.creaAggiornaPresenza'), [
//     'data' => '1976-11-19',
//     'collaborator_id'=> $collaboratore->id,
//     'importo' => $collaboratore->intera_giornata,
//     'tipo_di_presenza' => 'Intera giornata',
//     'luogo'=> 'Roma',
//     'descrizione' => 'Lorem',
//     'spese_rimborso' => '0.00',
//     'bonus' => '8.00',
// ]);

// $response = $this->get('/');

// $response->assertStatus(200);
