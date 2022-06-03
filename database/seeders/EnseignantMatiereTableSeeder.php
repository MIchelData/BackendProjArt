<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Matiere;

class EnseignantMatiereTableSeeder extends Seeder
{
    public function GetMatiere()
    {
        $XMLFichier = 'C:\Users\Cal89\Documents\heig\Semestre2\ProjetArt\calendrierxml_listeprof\import-final-21-10-2021.xml';
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
        $classes = [];
        $profs = [];
        foreach ($units as $unit){
            foreach ($unit->teaching as $teaching){
                $classes[] = (string) $teaching['tag'];

                    $profs[] = (string) $teaching->lesson[0]->teachers->teacher['idisa'];
            }
            //dd($profs);
            $abbreviationcorrecte = explode(" ",$unit['abbreviation']) ;
            //dd($abbreviationcorrecte[0]);
            $listecomplete = array($abbreviationcorrecte[0], $classes, $profs);
            dd($listecomplete);
        }

       // dd(count($unit));
        for($i=0; $i<27; $i++){
            $prof =  $XmlData->aperiodic[0]->unit[$i]->teaching->lesson->teachers->teacher ;
            if($prof != null ) {
                $Prof_id[$i] = (string) $prof['idisa'];
            }


        }
       // for($i=0; $i<10; $i++){

         //   $i+=10;
          //  $prof =  $XmlData->aperiodic[0]->unit[$i]->teaching->lesson->teachers->teacher ;
          //  $Prof_id[] = (string) $prof['idisa'];

        //}

        $IdListe= [];
        foreach($Prof_id  as $p ){
            $IdListe[]=explode(" ",$p);
        }


        return $Prof_id;

    }
    public function rendnomprof() {
        $chemin = 'C:\Users\Cal89\Documents\heig\Semestre2\ProjetArt\calendrierxml_listeprof\ID-professeurs.txt';
       $listeprof = file_get_contents($chemin);
       $listeprofexplose = explode(",", $listeprof);

        foreach($listeprofexplose as $key => $value){
            if($value == "" || $value=="\r\n"){
                unset($listeprofexplose[$key]);
            }
        }


    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $profid = $this->GetMatiere();
       dd($profid);
      $listeprofnomid =  $this->rendnomprof();
       // $listematiere = Matiere::limit(3)->get();
       // dd($listematiere);
        //App\Models\Matiere::where('user_id','10')->orderBy('nbSecondes','ASC')->get();

        DB::table('enseignant_matiere')->insert([

              'enseignant_id' => 'sas',
                'matiere_id' => 'asas'
        ]);
    }
}
