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
            $table->integer('date');
            $table->integer('duree');
            $table->text('description');
            $table->string('titre');
            $table->string('classe');
            $table->foreignId('id_eleve')->nullable()->constrained('eleves');
            $table->foreignId('id_enseignant')->nullable()->constrained('enseignants');
            $table->foreignId('id_matiere')->nullable()->constrained('matieres');
    });
}

    public function down()
    {
        Schema::dropIfExists('taches_publique');
    }
};
