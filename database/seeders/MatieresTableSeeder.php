<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
//domdocument
use DOMDocument;
use DOMXPath;

class MatieresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function GetMatiere()
    {  
        $XMLFichier = storage_path('app' . DIRECTORY_SEPARATOR . 'import-final-21-10-2021.xml') ;;
        $XmlData = simplexml_load_file($XMLFichier) or die("Failed to load");
        /* dd($XmlData->unit[2]['abbreviation'] . "<br>");
         $doc = new DOMDocument();
         $doc->loadXML(file_get_contents($XMLFichier));
         $DomNodeList = $doc->getElementsByTagName( 'unit' ); */
        /* foreach($DomNodeList as $domNode) {
            $cours[]=$domNode->getElementsByTagName('unit');
        } */
        /*  dd($cours);
         $xpath = new DOMXpath($doc);
         $nodes = $xpath->query('//*');
         $names = array();
         foreach ($nodes as $node) {
             $names[] = $node->nodeName;
         }
         dd($names); */


        $nommatiereclasse = [];
        $classe=48;
        $noclasse=1;
        $listeclasse=[];

        /* dd($XmlData->aperiodic[0]->unit->{'abbreviation'}); */
        foreach ( $XmlData->aperiodic[0]->unit as $Matiere) {

            foreach ($Matiere->teaching as $teaching){
               // dd($Matiere['abbreviation']);
                $matiereexplose=explode(" ",$Matiere['abbreviation']);
               // dd($matiereexplose[0][0]);
                $nommatiere = (string) $matiereexplose[0];
               // dd($nommatiere);
                $nommatiereclasse[] =$nommatiere."".$teaching['tag'];
                

            }


        }
       
        //dd($matiereexplose);
        //dd($nommatiereclasse);




        /* foreach($matiereListe as $m){
        for ($i=1; $i <4 ; $i++) { 
            
                $matiereListe2[]="M".$classe."_".$noclasse."_".$m[0];
                $noclasse++;
                $classe++;
            
            
        }
        $classe=49;
        $noclasse=1;
    } */
      
       
        
        /* $matiereListe=explode(" ",$Matieres[0]); */
       // dd($matiereListe2);
        return $nommatiereclasse;
        /* dd($Matieres);
        $test=$Matieres[24];
        dd($test);
        dd($Matieres); */
    }
    public function run()
    {
        $listematiere = $this->GetMatiere();
        foreach($listematiere as $key=>$value){
            /* dd($value[1]); */
            DB::table('matieres')->insert([
                'nom' => $value,
                /* 'id_enseignant'=>rand(1,100)   */

            ]);

        }
        /* foreach ($listematiere as $matiere) {
            DB::table('matieres')->insert([
                'nom' => $matiere,

            ]);
        } */
    }
}
