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
        Schema::create('classe_eleve', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->foreign('id_eleve')->references('id')->on('eleves')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('id_classe')->references('id')->on('classe')
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
        Schema::dropIfExists('classe_eleve');
    }
};
