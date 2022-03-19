<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDescrizioneSpeseRimborsoBonusInPresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->string('descrizione')->nullable()->change();
            $table->bigInteger('spese_rimborso')->nullable()->change();
            $table->bigInteger('bonus')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->string('descrizione');
            $table->bigInteger('spese_rimborso');
            $table->bigInteger('bonus');
        });
    }
}
