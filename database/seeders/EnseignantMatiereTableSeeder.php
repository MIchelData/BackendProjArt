<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Matiere;
use App\Models\Enseignant;
use Illuminate\Support\Facades\DB;

class EnseignantMatiereTableSeeder extends Seeder
{
    public function GetMatiere()
    {   
        $XMLFichier = storage_path('app' . DIRECTORY_SEPARATOR . 'import-final-21-10-2021.xml') ;
        $XmlData = simplexml_load_file($XMLFichier) or die("Failed to load");
        $Matieres = [];
        foreach ( $XmlData->aperiodic[0]->unit as $Matiere) {
            $Matieres[] =(string) $Matiere['abbreviation'];

        }
        foreach($Matieres  as $m ){
            $matiereListe[]=explode(" ",$m);
        }
        $Prof_id = [];
        $listecomplete = [];
        $units = $XmlData->aperiodic[0]->unit;
        //$classes = [];
        //$profs = [];
        $brancheclasseprof = [];
        foreach ($units as $unite){
            $currentunit = explode(" ",(string) $unite['abbreviation']);
            $currentunit = $currentunit[0];
            unset($classes);
            unset($profs);
            foreach ($unite->teaching as $teaching){
                $classes[] = (string) $teaching['tag'];
                    if($teaching->lesson[0]->teachers->teacher!=null) {
                        $profs[] = (string)$teaching->lesson[0]->teachers->teacher['idisa'];
                    }else{
                        $profs[] = "";
                    }
            }

            array_push($listecomplete,array($currentunit, $classes, $profs));

        }

        return $listecomplete;



    }
    public function rendnomprof() {
       
        $chemin =  storage_path('app' . DIRECTORY_SEPARATOR . 'ID-professeurs.txt') ;
       $listeprof = file_get_contents($chemin);
       $listeprofexplose = explode(",", $listeprof);
        //dd($listeprofexplose);
       // foreach($listeprofexplose as $key => $value){
         //   if($value == "" || $value=="\r\n"){
          //      unset($listeprofexplose[$key]);
          //  }

        return $listeprofexplose;


    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $listeprofclasse = $this->GetMatiere();



      $listeprofnomid =  $this->rendnomprof();
      array_shift($listeprofnomid);

        DB::table ('enseignant_matiere')->delete();
$i = 0;
        foreach ($listeprofclasse as $profclasse){
            $i++;
            foreach ($profclasse[1] as $key => $classe){

                $nomclasse = $profclasse[0]."".$classe;
                //dd($nomclasse);
                $matiereId = Matiere::where('nom',$nomclasse)->get('id');
                //dd($matiereId[0]->id);

                $key = array_search($profclasse[2][$key], $listeprofnomid);

                if($key != false) {

                    //dd($listeprofnomid[$key-1]);

                    $enseignantNomPrenom = $listeprofnomid[$key - 1];
                    $enseignantNom = explode(" ", $enseignantNomPrenom);
                    $enseignantNom = trim($enseignantNom[0]);



                    // dd($enseignantNom);

                    $enseignantId = Enseignant::where('nom', $enseignantNom)->get('id');




                    DB::table('enseignant_matiere')->insert([
                        'enseignant_id' => $enseignantId[0]->id,
                        'matiere_id' => $matiereId[0]->id
                    ]);
                }

            }
        }


    }
}
