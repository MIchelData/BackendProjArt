<?php

namespace Database\Seeders;

use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Matiere;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EleveMatiereTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nbreleves = Eleve::all();
        $listematiere = Matiere::all();
        $i=0;
        foreach ($nbreleves as $eleves){
            $classe = $eleves->classe;
            foreach ($listematiere as $matiere){
                if(str_contains($matiere->nom, $classe)){
                    DB::table('eleve_matiere')->insert([
                        'eleve_id'=> $eleves->id,
                        'matiere_id'=>$matiere->id,
                    ]);
                }
            }


        }





    }
}
