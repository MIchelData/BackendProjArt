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
        Schema::create('matiere_m-49-1', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
          $table->string('nom');
          $table->integer('id_enseignant');
            $table->foreign('id_enseignant')->references('id')->on('enseignants')
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
        Schema::dropIfExists('matieres_m-49-1');
    }
};
