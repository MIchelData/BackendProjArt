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

        DB::table('taches_publique')->insert([
            'description' => "1 pages A4 recto verso",
            'date' => strtotime("20-07-2022 18:30:23"),
            'duree' => '240',
            'titre' => 'Test de math',
            'id_enseignant' => 1,
            'id_eleve' => null,
            'classe' => "M49-1",
            'type' => 'Test']);



        DB::table('taches_publique')->insert([
                'description' => "tout documents autorisés",
                'date' => strtotime("20-06-2022 18:30:23"),
                'duree' => 240,
                'titre' => "examen de prog",
                'id_enseignant' => 2,
                'id_eleve' => null,
                'classe' => "M50-2",
                'type' => 'Test',
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
            'classe' => "M50-3",
            'id_matiere'=> null,
            'type' => 'examen']);

                DB::table('taches_publique')->insert([
                    'description' => "tout documents autorisés",
                    'date' => strtotime("2020-10-10 18:30:23"),
                    'duree' => '60',
                    'titre' => 'Repas canadien comem',
                    'id_enseignant' => null,
                    'id_eleve' => 1,
                    'classe' => "M48",
                    'type' => 'autre']);


    }









}
