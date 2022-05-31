<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElevesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('eleves')->delete();
        for ($i=1; $i<=20 ; $i++) { 
        DB::table('eleves')->insert([
                'nom' => 'nom'.$i,
                'prenom' => 'prenom'.$i,
                'email' => 'email'.$i,
                'id_classe' => rand(1,3)]);
         }   
    }
}
