<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EnseignantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table ('enseignants')->delete();
        for ($i=0; $i <45 ; $i++) { 
            DB::table('enseignants')->insert([
                'id_user'=>$i ]);
        }
    }
}
