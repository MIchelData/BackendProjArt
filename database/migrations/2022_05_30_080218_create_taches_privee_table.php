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
            $table->integer('date');
            $table->integer('duree');
            $table->text('description');
            $table->foreignId('id_eleve')->nullable()->constrained('eleves');

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
