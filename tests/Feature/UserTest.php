<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

//use Illuminate\Foundation\Testing\DatabaseMigrations;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_utente_con_permesso()
    {
        /* Creo un utente con livello 1 (con permesso) */
        $utente = User::factory()->create([ 'level' => '1']);

        /* Con l'utente appena creato gli faccio creare un record */
        $response = $this->actingAs($utente)->post(route('utenti.store'), [
            'name' => 'marco',
            'email' => 'marco@gmail.com',
            'password' => Hash::make('ciaociao'),
            'level' => 1
        ]);

        /* Controllo se il record e stato creato */
        $this->assertDatabaseHas('users', [
            'name' => 'marco',
        ]);

        /* Una volta creato controllo che ritorna a utenti.index */
        $response->assertRedirect(route('utenti.index'));
    }


    public function test_utente_senza_permesso()
    {
        /* Creo un utente con livello 0 (senza permesso) */
        $utente = User::factory()->create([
            'level' => '0'
        ]);

        /* vedo se l'utente ha i permesso di andare alla rotta utenti.store */
        $response = $this->actingAs($utente)->post(route('utenti.store'));

        /* Gli do lo stato 403 perche l'utente non ha il permesso e quindi fallisce */
        $response->assertStatus(403);
    }
}








// public function test_aggiungere_categoria()
// {
//     //$this->withoutExceptionHandling();

//     // Creo utente amministratore con factory
//     $user = User::factory()->create(['livello_accesso' => '1']);

//     // Aggiungo un record
//     $response = $this->actingAs($user)->post(route('categorie.store'), [
//         'descrizione' => 'pippo',
//     ]);

//     $this->assertDatabaseHas('categorie', [
//         'descrizione' => 'pippo',
//     ]);

//     //Controlla se viene ridirezionato in:
//     $response->assertRedirect(route('categorie.index'));
// }



    // public function test_utente_senza_permesso()
// {
//     $utenteConPermessi = User::factory()->create([
//         'level' => 1
//     ]);
//     $utenteSenzaPermessi = User::factory()->create([
//         'level' => 0
//     ]);

//     $response = $this->actingAs($utenteSenzaPermessi)->get(route('utenti.index'));

//     $response->assertRedirect(route('utenti.index'));

//     $response->assertStatus(403);
// }
