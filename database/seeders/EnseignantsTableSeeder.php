<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EnseignantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
public function listeprof(){
    $chemin = storage_path('app' . DIRECTORY_SEPARATOR . 'ID-professeurs.txt') ;
    $liste_prof = file_get_contents($chemin);
    

    return $listenomprenomprof;
}

        public function getEnseignants()
        {

            //go to the file and get the content Liste_Enseignants.csv

  //'\..\storage\app\Liste_Enseignants.csv'
            
            $ListeEnseignantsChemin = storage_path('app' . DIRECTORY_SEPARATOR . 'Liste_Enseignants.csv');
           
            $ListeEnseignants = [];
            $f = fopen($ListeEnseignantsChemin, "r");
            if ($f === false) {
                die('Cannot open the file ' . $ListeEnseignantsChemin);
            }
            while (($row = fgetcsv($f, 10000, ";")) !== false) {
                $ListeEnseignants[] = $row;

            }

            return $ListeEnseignants;
        }
    public function run()
    {
        $listeenseignants = $this->getEnseignants();
        array_shift($listeenseignants);
        DB::table ('enseignants')->delete();
        foreach ($listeenseignants as $enseignant){
            $listecours="";
            for($i=3; $i<count($enseignant); $i++){
                if($enseignant[$i]!=""){
                    $listecours = $listecours.";".$enseignant[$i];
                }

            }

            DB::table('enseignants')->insert([
                'nom'=>trim($enseignant[1]),
                'prenom'=>trim($enseignant[2]),
                'email'=>strtolower($enseignant[2]).".".strtolower($enseignant[1])."@heig-vd.ch",
                'admin'=>0,
                'branche'=> $listecours,
                'password'=> Hash::make($enseignant[2]."".$enseignant[1])
            ]);
        }
    }
}
