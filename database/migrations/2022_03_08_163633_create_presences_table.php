<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->id();

            $table->date('data_inizio');
            $table->date('data_fine');
            $table->unsignedBigInteger('collaborator_id');
            $table->string('tipo_di_presenza');
            $table->string('luogo');
            $table->string('descrizione');
            $table->bigInteger('spese_rimborso');
            $table->bigInteger('bonus');
            $table->foreign('collaborator_id')->references('id')->on('collaborators')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presences');
    }
}
