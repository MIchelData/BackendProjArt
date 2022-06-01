<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CoursEnseignantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('cours_enseignant')->delete();
        for ($i=1; $i <10 ; $i++) { 
           
            DB::table('cours_enseignant')->insert([
                'id_cours' => $i,
                'id_enseignant' => $i]);
        }
    }
}
