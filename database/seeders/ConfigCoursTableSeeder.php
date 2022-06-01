<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigCoursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function getCalendrier(){
        $coursdifferents = [];
        $listedescours = [];
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
        foreach ($listenomfichiers as $file){
            $chemincomplet = 'C:\Users\Cal89\Documents\heig\Semestre2\ProjetArt\horairesics\Horaire'.$file;
            $calendrier = file_get_contents($chemincomplet);
            $matchdstart = '/DTSTART;(.*)/';
            $matchend = '/DTEND;(.*)/';
            $matchsalle ='/LOCATION:(.*)/';
            $matchnomcours = '/SUMMARY:(.*)/';


            // /.*?base64(.*?)/g
            $n = preg_match_all($matchdstart, $calendrier,$datestart, PREG_PATTERN_ORDER);
            preg_match_all($matchend,$calendrier,$datesend,PREG_PATTERN_ORDER);
            preg_match_all($matchsalle, $calendrier, $salles, PREG_PATTERN_ORDER );
            preg_match_all($matchnomcours,$calendrier, $nomcours, PREG_PATTERN_ORDER);


            foreach ($nomcours[1] as $value){
                if(in_array(trim($value), $coursdifferents)){

                }else{
                    array_push($coursdifferents, trim($value));
                }
            }

        }

        return $coursdifferents;
    }

    public function run()
    {
        $listecours = $this->getCalendrier();
        $listecoursdifferents = [];

        foreach ($listecours as $cours){
            //dd(substr($cours, 0,6));
            if(in_array(substr($cours,0,6),$listecoursdifferents,)){

            }else{
                array_push($listecoursdifferents, substr($cours,0,6));
            }
        }
        $coursEtModule = [];
        foreach ($listecoursdifferents as $key => $coursdiff){
            array_push($coursEtModule,array($coursdiff, rand(1,38)));
        }
        //dd($coursEtModule);
        DB::table('config_cours')->delete();
        $module = 0;
       foreach ($listecours as $nomcours){
           foreach ($coursEtModule as $refmod){
               if(in_array(substr($nomcours, 0,6), $refmod)){
                   $module = $refmod[1];
               }
           }

           DB::table('config_cours')->insert([
               'nom' => $nomcours,
                'id_module' => $module
           ]);
       }
    }
}
