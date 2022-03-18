<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Collaborators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborators', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->string('cognome');
            $table->string('email');
            $table->bigInteger('telefono');
            $table->string('citta');
            $table->string('indirizzo');
            $table->bigInteger('CAP');
            $table->bigInteger('intera_giornata');
            $table->bigInteger('mezza_giornata');
            $table->bigInteger('giornata_estero');
            $table->bigInteger('giornata_formazione');

            $table->timestamps();
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
