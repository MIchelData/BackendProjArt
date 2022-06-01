<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class salleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function getCalendrier(){
        $sallesdifferentes = [];
        $listesalles = [];
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

           array_shift($salles[1]);
           foreach ($salles[1] as $salle){
               if($salle != ""){
                   $str_arr = explode (",", $salle);
                   foreach ($str_arr as $sallesepare){
                       array_push($listesalles,$sallesepare);
                   }
               }

           }
           //dd($listesalles);
          //  $sallesdifferentes= ["",""];
           // dd($sallesdifferentes);
           foreach ($listesalles as $value){
              if(in_array(trim($value), $sallesdifferentes)){

              }else{
                   array_push($sallesdifferentes, trim($value));
               }
           }
       }

        return $sallesdifferentes;

    }

    public function run()
    {

      $listedessalles = $this->getCalendrier();
        DB::table('salles')->delete();
      foreach($listedessalles as $value){
          DB::table('salles')->insert([
              'nom'=>$value
        ]);

          }

      }


}
