<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class calendrierController extends Controller
{
    public function getCalendrier(){
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
}
