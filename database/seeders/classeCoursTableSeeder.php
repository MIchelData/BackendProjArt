<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class classeCoursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function getcoursclass(){

        $listenomfichiers = ["_M48_S2_2021_2022.ics",
            "_M49-1_S1_2021_2022.ics",
            "_M49-1_S2_2021_2022.ics",
            "_M49-2_S1_2021_2022.ics",
            "_M49-2_S2_2021_2022.ics",
            "_M50-1_S1_2021_2022.ics",
            "_M50-1_S2_2021_2022.ics",
            "_M50-2_S1_2021_2022.ics",
            "_M50-2_S2_2021_2022.ics",
            "_M50-3_S1_2021_2022.ics",
            "_M50-3_S2_2021_2022.ics"];



            $file = 'C:\Users\Cal89\Documents\heig\Semestre2\ProjetArt\horairesics\Horaire_M48_S2_2021_2022.ics';
            $calendrier = file_get_contents($file);

            $matchdstart = '/DTSTART;(.*)/';
            $matchend = '/DTEND;(.*)/';
            $matchsalle ='/LOCATION:(.*)/';
            $matchnomcours = '/SUMMARY:(.*)/';
            $listedessalles = [];

            // /.*?base64(.*?)/g
            $n = preg_match_all($matchdstart, $calendrier,$datestart, PREG_PATTERN_ORDER);
            preg_match_all($matchend,$calendrier,$datesend,PREG_PATTERN_ORDER);
            preg_match_all($matchsalle, $calendrier, $salles, PREG_PATTERN_ORDER );
            preg_match_all($matchnomcours,$calendrier, $nomcours, PREG_PATTERN_ORDER);
            //$str_arr = explode (",", $salles[1][1]);
            //dd($str_arr);
            array_shift($salles[1]);
            foreach ($salles[1] as $salle){
                if($salle != ""){
                    $str_arr = explode (",", $salle);
                    foreach ($str_arr as $sallesepare){
                        array_push($listedessalles,$sallesepare );
                    }
                }

            }
            dd($nomcours);

    }

    public function run()
    {
        $listenomfichiers = ["_M48_S2_2021_2022.ics",
            "_M49-1_S1_2021_2022.ics",
            "_M49-1_S2_2021_2022.ics",
            "_M49-2_S1_2021_2022.ics",
            "_M49-2_S2_2021_2022.ics",
            "_M50-1_S1_2021_2022.ics",
            "_M50-1_S2_2021_2022.ics",
            "_M50-2_S1_2021_2022.ics",
            "_M50-2_S2_2021_2022.ics",
            "_M50-3_S1_2021_2022.ics",
            "_M50-3_S2_2021_2022.ics"];


       // DB::table('classe_cours')->delete();

foreach($listenomfichiers as $key1 => $fichier){
    $file = 'C:\Users\Cal89\Documents\heig\Semestre2\ProjetArt\horairesics\Horaire'.$fichier;
    $nomclasse = "";
    if(substr($fichier, 1, 5)=="M48_S"){
            $nomclasse = "M48-1";
    }else {
        $nomclasse = substr($fichier, 1, 5);
        dd(substr($fichier, 1, 5));
    }
    $calendrier = file_get_contents($file);
    $matchnomcours = '/SUMMARY:(.*)/';
    preg_match_all($matchnomcours, $calendrier,$nomcours,PREG_PATTERN_ORDER);
    foreach ($nomcours as $key2 => $nomcour){
        DB::table('classe_cours')->insert([
            'id_classes' => $nomclasse,
            'id_config_cours' => "Bonjour"]);
    }

}

}

}
