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

    return $listenomprenomprof;
}

    public function getEnseignants()
    {

        $ListeEnseignantsChemin = 'C:\Users\Cal89\Documents\heig\Semestre2\ProjetArt\listesEtudiantsProffs\Liste_Enseignants.csv';
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
                'nom'=>$enseignant[1],
                'prenom'=>$enseignant[2],
                'email'=>$enseignant[2].".".$enseignant[1]."@heig-vd.ch",
                'admin'=>0,
                'branche'=> $listecours
            ]);
        }
    }
}
