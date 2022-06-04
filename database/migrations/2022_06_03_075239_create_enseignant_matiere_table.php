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
        Schema::create('enseignant_matiere', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->foreignId('enseignant_id')->constrained('enseignants');
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
        Schema::dropIfExists('enseignant_matiere');
    }
};
