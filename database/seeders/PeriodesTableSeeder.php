<?php

namespace Database\Seeders;
use App\Models\Salle;
use App\Models\Matiere;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PeriodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */



    public function run()
    {
$i=0;
        DB::table('periodes')->delete();
        $XMLFichier = storage_path('app' . DIRECTORY_SEPARATOR . 'import-final-21-10-2021.xml') ;
        $XmlData = simplexml_load_file($XMLFichier) or die("Failed to load");
        $listedates = [];
        $listedatefin = [];
        /* dd($XmlData->aperiodic[0]->unit->{'abbreviation'}); */
       // dd($XmlData->aperiodic[0]);
        foreach ($XmlData->aperiodic[0]->unit as $unite){
            foreach ($unite->teaching as $teaching){
        foreach ( $teaching->lesson as $cours) {
            foreach($cours->rooms->room as $salle){
                $nomSalle=(string)$salle['name'];
            }

            //dd($cours['start']);
            $minutesdebut = 510;
            $minutespauseAvant = 0;
            $minutespausePendant = 0;
            if ($cours['start'] > 2) {
                $minutespauseAvant += 30;
            }
            if ($cours['start'] > 5) {
                $minutespauseAvant += 30;
            }
            if ($cours['start'] > 7) {
                $minutespauseAvant += 15;
            }

            $datedebutminutes = (((integer)$cours['start'] - 1) * 45) + $minutesdebut + $minutespauseAvant;

            if ($datedebutminutes + ((integer)$cours['duration'] * 45) > 600 && $datedebutminutes + ((integer)$cours['duration'] * 45) < 885) {
                $minutespausePendant += 30;
            }
            //if($datedebutminutes+((integer)$cours['duration'] * 45)>765){
            //    $minutespausePendant +=30;
            // }
            if ($datedebutminutes + ((integer)$cours['duration'] * 45) > 885) {
                $minutespausePendant += 15;
            }

            $datefinminutes = $datedebutminutes + ((integer)$cours['duration'] * 45) + $minutespausePendant;

            $tempsheuresdebut = intval(floor($datedebutminutes / 60));
            $tempsminutesdebut = ($datedebutminutes % 60);
            $tempsheuresfin = intval(floor($datefinminutes / 60));
            $tempsminutesfin = ($datefinminutes % 60);

            //dd($tempsheuresdebut, $tempsminutesdebut,$tempsheuresfin, $tempsminutesfin );
            //dd($cours['date'].' '.$tempsheuresdebut.':'.$tempsminutesdebut);
            $datedebut = strtotime($cours['date'] . ' ' . $tempsheuresdebut . ':' . $tempsminutesdebut);
            $datefin = strtotime($cours['date'] . ' ' . $tempsheuresfin . ':' . $tempsminutesfin);
            // dd(date('Y-m-d h:i',$datedebut));
            //date('Y-m-d h:i',$datedebut)
            //date('Y-m-d h:i',$datefin)
            $nom = $unite['abbreviation'];
            $nomexplose=explode(" ",$nom);
            $nom = $nomexplose[0];
            $classe = (string) $teaching['tag'];
            $nomclasse = $nom."".$classe;
            $matiereId = Matiere::where('nom',$nomclasse)->get('id');
            $salleID=Salle::where('nom',$nomSalle)->get('id');
           // dd($nomclasse);
           // dd(Matiere::where('nom', "AnalysMar-M50-1")->get('id'));

            DB::table('periodes')->insert([

                'date_debut' => $datedebut,  // date('Y-m-d h:i', $datedebut)
                'date_fin' =>  $datefin, //  date('Y-m-d h:i', $datefin)

                'date_debut' => $datedebut,
                'date_fin' =>  $datefin,
                'matiere_id'=> $matiereId[0]->id,
                'salle_id'=> $salleID[0]->id
            ]);
           // if($i=10){

          //  }
        $i++;
        }
        }
        }



    }
}
