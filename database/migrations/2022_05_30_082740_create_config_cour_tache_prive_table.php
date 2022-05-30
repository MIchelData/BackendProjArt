<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_cour_tache_prive', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->foreign('id_tache_privee')->references('id')->on('tache_privee')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('id_cours')->references('id')->on('config_cours')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_cour_tache_prive');
    }
};
