<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresenzeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presenze', function (Blueprint $table) {
            $table->id();

            $table->date('data');
            $table->unsignedBigInteger('collaborator_id');
            $table->bigInteger('importo');
            $table->string('tipo_di_presenza');
            $table->string('luogo');
            $table->string('descrizione')->nullable();
            $table->bigInteger('spese_rimborso')->nullable();
            $table->bigInteger('bonus')->nullable();
            $table->foreign('collaborator_id')->references('id')->on('collaboratori')->onDelete('cascade');

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
        Schema::dropIfExists('presenze');
    }
}
