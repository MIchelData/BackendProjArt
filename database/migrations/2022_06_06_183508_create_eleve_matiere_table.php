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
        Schema::create('eleve_matiere', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->foreignId('eleve_id')->constrained('eleves');
            $table->foreignId('matiere_id')->constrained('matieres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eleve_matiere');
    }
};
