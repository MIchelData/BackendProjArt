<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CoursEleveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cours_eleve')->delete();
        for ($i=1; $i < 22 ; $i++) { 
            DB::table('cours_eleve')->insert([
                'id_cours' => $i,
                'id_eleve' => $i]);
        }
    }
}
