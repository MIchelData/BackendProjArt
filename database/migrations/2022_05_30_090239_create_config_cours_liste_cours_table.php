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
        Schema::create('config_cours_liste_cours', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->foreign('id_config_cours')->references('id')->on('config_cours')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('id_liste_cours')->references('id')->on('liste_cours')
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
        Schema::dropIfExists('config_cours_liste_cours');
    }
};
