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
        Schema::create('liste_cours', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('id_salle');
            $table->foreign('id_salle')->references('id')->on('salles')
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
        Schema::dropIfExists('liste_cours');
    }
};
