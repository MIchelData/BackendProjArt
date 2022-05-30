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
        Schema::create('table_config_cours', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_eleves');
            $table->integer('id_enseignants');
            $table->integer('id_salles');
            $table->integer('id_classes');
            $table->integer('id_module');
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
        Schema::dropIfExists('table_config_cours');
    }
};
