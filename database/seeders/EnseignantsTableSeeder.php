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
public function listeprof(){
    $chemin = 'C:\Users\Cal89\Documents\heig\Semestre2\ProjetArt\calendrierxml_listeprof\ID-professeurs.txt';
    $liste_prof = file_get_contents($chemin);
    dd($liste_prof);
    
    return $listenomprenomprof
}


    public function run()
    {
        $this->listeprof();
        DB::table ('enseignants')->delete();
        for ($i=0; $i <45 ; $i++) {
            DB::table('enseignants')->insert([
                'id_user'=>$i ]);
        }
    }
}
