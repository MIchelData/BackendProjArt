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
        Schema::create('cours_eleve', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->foreign('id_eleves')->references('id')->on('eleves')
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
        Schema::dropIfExists('cours_eleve');
    }
};
