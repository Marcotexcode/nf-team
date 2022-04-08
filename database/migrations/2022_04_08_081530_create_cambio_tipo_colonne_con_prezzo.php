<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCambioTipoColonneConPrezzo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presenze', function (Blueprint $table) {
            $table->decimal('importo', 4, 2)->change();
            $table->decimal('spese_rimborso', 4, 2)->nullable()->change();
            $table->decimal('bonus', 4, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presenze', function (Blueprint $table) {
            $table->bigInteger('importo')->change();
            $table->bigInteger('spese_rimborso')->nullable()->change();
            $table->bigInteger('bonus')->nullable()->change();
        });
    }
}
