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
        $XMLFichier = 'C:\Users\johna\Desktop\Projart\doc\import-final-21-10-2021.xml';
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


        $Matieres = [];
       /* dd($XmlData->aperiodic[0]->unit->{'abbreviation'}); */
        foreach ( $XmlData->aperiodic[0]->unit as $Matiere) {
            $Matieres[] =(string) $Matiere['abbreviation'];
            
        }
        foreach($Matieres  as $m ){
            $matiereListe[]=explode(" ",$m);
        }
        
        /* $matiereListe=explode(" ",$Matieres[0]); */
        /* dd($matiereListe); */
        return $matiereListe;
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
            DB::table('matiere')->insert([
                'nom' => $value[0],
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