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
        Schema::create('taches_publique', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('type');
            $table->date('date');
            $table->integer('duree');
            $table->string('description');
            $table->string('infos');
            $table->foreign('id_enseignants')->references('id')->on('enseignants')
                ->onDelete('restrict')
                ->onUpdate('restrict');
    });
}

    public function down()
    {
        Schema::dropIfExists('taches_publique');
    }
};