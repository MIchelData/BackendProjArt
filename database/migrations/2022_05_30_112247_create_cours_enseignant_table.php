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
        Schema::create('cours_enseignant', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->foreignId('id_enseignants')->constrained('enseignants');
            /* $table->foreign('id_enseignants')->references('id')->on('enseignants')
                ->onDelete('restrict')
                ->onUpdate('restrict'); */
            $table->foreignId('id_cours')->constrained('config_cours');
            /* $table->foreign('id_cours')->references('id')->on('config_cours')
                ->onDelete('restrict')
                ->onUpdate('restrict'); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cours_enseignant');
    }
};
