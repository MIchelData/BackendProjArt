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
        Schema::create('config_cours', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_module')->unsigned();
            $table->foreign('id_module')->references('id')->on('modules')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->string('nom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_config_cours');
    }
};
