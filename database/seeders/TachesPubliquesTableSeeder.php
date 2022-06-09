<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TachesPubliquesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taches_publique')->delete();

        /* DB::table('taches_publique')->insert([
            'description' => "2 page A4 avec l'ensemble des élèves de la classe",
            'date' => '2020-05-01',
            'duree' => '240',
            'titre' => 'rendu trombinoscope',
            'id_enseignant' => 1,
            'id_eleve' => 0,
            'type' => 'devoir']); */



        DB::table('taches_publique')->insert([
                'description' => "tout documents autorisés",
                'date' => strtotime("20-06-2022 18:30:23"),
                'duree' => 240,
                'titre' => "examen de prog",
                'id_enseignant' => 2,
                'id_eleve' => null,
                'type' => 'examen',
                'id_matiere'=> 8,

        ]);

        DB::table('taches_publique')->insert([
            'description' => "bord du lac",
            'date' => strtotime("25-06-2022 16:30:00"),
            'duree' => 240,
            'titre' => "apéro",
            'id_enseignant' => null,
            'id_eleve' => 1,
            'type' => 'autre',
            'id_matiere'=> null,

        ]);



    }


    /* $table->increments('id');
    $table->timestamps();
    $table->string('type');
    $table->date('date');
    $table->integer('duree');
    $table->string('description');
    $table->string('titre');
    $table->foreignId('id_user')->constrained('users');
}); */






}
