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
        Schema::create('classe_cours', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_classes')->unsigned();
            $table->integer('id_config_cours')->unsigned();
            $table->foreign('id_classes')->references('id')->on('classes')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('id_config_cours')->references('id')->on('config_cours')
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
        Schema::dropIfExists('classe_cours');
    }
};
