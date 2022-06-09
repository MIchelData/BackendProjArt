<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TachePriveeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

        {

            // $date = time();
            // $date2 = strtotime("20-06-2022 14:30:23");


            DB::table('taches_privee')->delete();


            DB::table('taches_privee')->insert([
                'titre' => "faire exercice jour 8 prog",
                'description' => "",
                'date' => strtotime("20-06-2022 18:30:23"),
                'duree' => '240',
                'id_eleve' => 1
            ]);

            DB::table('taches_privee')->insert([
                'titre' => "manger avec Maman",
                'description' => "",
                'date' => strtotime("22-06-2022 12:30:23"),
                'duree' => '120',
                'id_eleve' => 1
            ]);

            DB::table('taches_privee')->insert([
                'titre' => "chasse avec tonton",
                'description' => "forêt du Risoud",
                'date' => strtotime("27-06-2022 05:30:23"),
                'duree' => '560',
                'id_eleve' => 1
            ]);


        }

}
