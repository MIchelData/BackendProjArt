<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ClasseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classes')->delete();
        DB::table('classes')->insert([
            'nom' => 'M48-1',
            'annee' => '2019']);

        for ($i=1; $i<=2 ; $i++) {
        DB::table('classes')->insert([
                'nom' => 'M49-'.$i,
                'annee' => '2020']);
         }
      for ($i=1; $i<=3 ; $i++) {
        DB::table('classes')->insert([
                'nom' => 'M50-'.$i,
                'annee' => '2021']);
         }



        }
}
