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
        Schema::create('config_cour_tache_publique', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->foreignId('id_tache_publique')->constrained('taches_publique');
           /*  $table->foreign('id_tache_publique')->references('id')->on('tache_publique')
                ->onDelete('restrict')
                ->onUpdate('restrict'); */
          /*   $table->foreign('id_cours')->references('id')->on('config_cours')
                ->onDelete('restrict')
                ->onUpdate('restrict'); */
                $table->foreignId('id_cours')->constrained('config_cours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_cour_tache_publique');
    }
};
