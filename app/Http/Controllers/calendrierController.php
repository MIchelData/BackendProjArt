<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Periode;
use App\Models\Salle;
use Illuminate\Http\Request;
use App\Models\Enseignant;
class instancehoraire
{
    public $matiere;
    public $date_debut;
    public $date_fin;
    public $salle;
}
class calendrierController extends Controller
{
    public function getCalendrier(){
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
        dd($nomcours);

    }

    public function getCoursEnseignant(){
$listehoraires = array();
    $enseignantMatiere = Enseignant::findOrFail(10)->matieres;

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

           $horaireDufour = new instancehoraire();
           $horaireDufour -> matiere = $ensma->nom;
           $horaireDufour -> date_debut = $permat->date_debut;
           $horaireDufour -> date_fin = $permat->date_fin;
           $horaireDufour -> salle = $salle;
           $listehoraires[] = $horaireDufour;
       }

    }
    $horaireJSON = json_encode($listehoraires);
    echo($horaireJSON);
}

public function getCoursTachesEleves(){ //permet d'afficher les cours dans l'ordre

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

    $horaireJSON = json_encode($listehoraires);
    echo($horaireJSON);

    foreach($horaireJSON as $periode){
            echo($periode->matiere);
            echo(" ");
            echo($periode->date_debut);
            echo(" ");
            echo($periode->date_fin);
    }

    }
}

