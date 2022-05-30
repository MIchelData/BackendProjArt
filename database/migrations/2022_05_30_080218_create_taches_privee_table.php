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
        Schema::create('taches_privee', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('titre');
            $table->date('date');
            $table->integer('duree');
            $table->string('description');
            $table->string('infos');
            $table->foreign('id_user')->references('id')->on('user')
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
        Schema::dropIfExists('taches_privee');
    }
};