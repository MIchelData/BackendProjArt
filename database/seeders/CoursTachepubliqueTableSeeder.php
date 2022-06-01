<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CoursTachepubliqueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        db::table('config_cour_tache_publique')->delete();
        for ($i=0; $i <6 ; $i++) { 
            DB::table('config_cour_tache_publique')->insert([
                'id_cours' => $i,
                'id_tache_publique' => $i]);
        }
   }
    
}
