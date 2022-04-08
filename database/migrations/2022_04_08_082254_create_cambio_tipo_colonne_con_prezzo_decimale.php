<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCambioTipoColonneConPrezzoDecimale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collaboratori', function (Blueprint $table) {
            $table->decimal('intera_giornata', 4, 2)->change();
            $table->decimal('mezza_giornata', 4, 2)->change();
            $table->decimal('giornata_estero', 4, 2)->change();
            $table->decimal('giornata_formazione', 4, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collaboratori', function (Blueprint $table) {
            $table->bigInteger('intera_giornata')->change();
            $table->bigInteger('mezza_giornata')->change();
            $table->bigInteger('giornata_estero')->change();
            $table->bigInteger('giornata_formazione')->change();
        });
    }
}
