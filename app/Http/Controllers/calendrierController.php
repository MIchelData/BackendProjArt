<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Periode;
use App\Models\Salle;
use App\Models\Tache_Privee;
use App\Models\Tache_Publique;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Enseignant;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class instancehoraire
{
    public $id;
    public $classe;
    public $title;
    public $startDate;
    public $endDate;
    public $localisation;
    public $typeEvent;
    public $description;
    public $event;
}
class calendrierController extends Controller
{

    public function tripardate($array) {
        usort($array, function($a, $b) {
            return $a->startDate - $b->endDate;
        });
        return $array;
    }

    public function nommatieretonomclasse($nommatiere){
        $tabcours= explode("M", $nommatiere);
        $classe = "M".$tabcours[count($tabcours)-1];
        return $classe;
    }

    public function getCalendrier(Enseignant $enseignant){
        $file = storage_path('app/horaire' . DIRECTORY_SEPARATOR . 'Horaire_M48_S2_2021_2022.ics') ;
        $calendrier = file_get_contents($file);
        dd($calendrier);
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
        dd($enseignant);

    }

    public function getCoursEnseignant(){
        $enseignant = Auth::guard('enseignant');
       // dd($enseignant->id());
$listehoraires = array();
    $enseignantMatiere = Enseignant::findOrFail($enseignant->id())->matieres;

        foreach ($enseignantMatiere as $ensma ){
        echo ($ensma->nom);
        $matiereId = $ensma->id;
        echo('<br><br>');
       $periodematiere = Matiere::findOrFail($matiereId)->periodes()->get();
       //dd($periodematiere[0]->date_debut);
       foreach ($periodematiere as $key => $permat){
     //      dd($permat);
           echo($ensma->nom);
           echo(" ");
           echo($permat->date_debut);
           echo(" ");
           echo($permat->date_fin);
           echo('<br><br>');
           $salle = Salle::findOrFail($permat->salle_id)->nom;
           $tabcours= explode("M", $ensma->nom);
           $classe = "M".$tabcours[count($tabcours)-1];
           $nom = $ensma->nom;
           $nom = str_replace($classe,"", $nom);
           $horaireprof = new instancehoraire();
           $horaireprof -> id = $ensma->id;
           $horaireprof -> classe = $classe;
           $horaireprof -> title = $nom;
           $horaireprof -> startDate = $permat->date_debut; //date('c', $permat->date_debut );
           $horaireprof -> endDate = $permat->date_fin; //date('c', $permat->date_debut );
           $horaireprof -> localisation = $salle;
           $horaireprof -> typeEvent = "course";
           $horaireprof -> description = "";
           $horaireprof -> event = "";
           $listehoraires[] = $horaireprof;
       }

    }



    //dd($enseignant->id());
    $listetachespublic = DB::table('taches_publique')
        ->where('id_enseignant', $enseignant->id())
        ->get();
    foreach ($listetachespublic as $tachepublic){
$idmatiere = $tachepublic->id_matiere;
        $classe = Matiere::where("id",$idmatiere)->get();
        $classe = $classe[0]->nom;
        $classe = $this->nommatieretonomclasse($classe);
        $tachepublicsprof = new instancehoraire();
        $tachepublicsprof -> id = $tachepublic->id;
        $tachepublicsprof -> classe = $classe;
        $tachepublicsprof -> title = $tachepublic->nom;
        $tachepublicsprof -> startDate = $tachepublic->date_debut;
        $tachepublicsprof -> endDate = $tachepublic->date_debut+($tachepublic->duree*60);
        $tachepublicsprof-> localisation = "T153";
        $tachepublicsprof-> typeEvent = $tachepublicsprof->type;
        $tachepublicsprof-> description = $tachepublicsprof->description;
        $tachepublicsprof-> event = "";
        $listehoraires [] = $tachepublicsprof;
        }
        usort($listehoraires, function($a, $b) {
            return $a->startDate - $b->endDate;
        });
        // dd($listehoraires);
        $horaireJSON = json_encode($listehoraires);
        echo($horaireJSON);

}

public function getCoursTachesEleves($enseignant){ //permet d'afficher les cours dans l'ordre

    $listeIdCours = array();
        $etudiantmatiere = Eleve::findOrFail(2)->matiere;
                    //orderBy('nbSecondes','ASC')->get();


        foreach ($etudiantmatiere as $etumat){

            array_push($listeIdCours,$etumat->id);
           // $periodes = Matiere::where('id',200)->periodes->get;
           // dd($periodes);

           // dd($periodes[0]->date_debut);
        }


        $listeCours = array();
        $listenomcours = array();
        foreach ($listeIdCours as $key => $lid){
            $listenomcours[$key] = Matiere::where('id', $lid)->get();
            $listeCours[$key] = Periode::with('matiere')
                ->orderBy('periodes.date_debut', 'asc')
                ->whereHas('matiere', function($q) use ($lid) {
                    $q->where('matieres.id', $lid);
                })->get();

        }
   // usort($array, function($a, $b) {
    //    return strtotime($a['date']) - strtotime($b['date']);
   // });

    $listehoraires = array();

    foreach ($listeCours as $key => $cours){
        foreach ($cours as $cour){
           // echo (date('Y-m-d h:i', $cour->date_debut));
           // echo ('<br><br>');
            $salleH = Salle::where('id', $cour->salle_id)->get('nom');
           // dd($listenomcours[$key][0]->nom);
            $horaire = new instancehoraire();
            $horaire -> matiere = $listenomcours[$key][0]->nom;
            $horaire -> date_debut = $cour->date_debut;
            $horaire -> date_fin = $cour->date_fin;
            $horaire -> salle = $salleH[0]->nom;
            $listehoraires[] = $horaire;
        }
        }
    //dd($listehoraires);
     usort($listehoraires, function($a, $b) {
        return $a->date_debut - $b->date_debut;
     });
    //dd($listehoraires);
$tacheprivee = Tache_Privee::where('id_eleve', 1)->get();
//dd($tacheprivee);
if(count($tacheprivee)!=0){
   // dd($tacheprivee);
}
$tachepublique = array();
//$listetest = ["0","1","2","8"];

foreach ($listeIdCours as $idcours){
    $latache = Tache_Publique::where('id_matiere', $idcours)->get();
    if(count($latache)>0){
        $tachepublique[] = Tache_Publique::where('id_matiere', $idcours)->get();
    }


}




    $horaireJSON = json_encode($listehoraires);
    echo($horaireJSON);

dd($enseignant);
   // foreach($horaireJSON as $periode){
    //    dd($periode);
      //      echo($periode->matiere);
      //      echo(" ");
      //      echo($periode->date_debut);
       //     echo(" ");
        //    echo($periode->date_fin);
         //   echo(" ");
         //   echo($periode->salle);
         //   echo('<br><br>');
    //}

    }
}

