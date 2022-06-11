<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\instancehoraire;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Salle;
use Illuminate\Http\Request;

class instancehoraire2
{
    public $id;
    public $classe;
    public $title;
    public $startDate;
    public $endDate;
    public $localisation;
    public $typeEvent;
    public $description;
}
class HoraireController extends Controller
{
    public function index(Request $request){
        $listehoraires = array();
        $id =  $request->user()->id;
        $enseignantMatiere = Enseignant::findOrFail($id)->matieres;

        foreach ($enseignantMatiere as $ensma ){
           // echo ($ensma->nom);
            $matiereId = $ensma->id;
            //echo('<br><br>');
            $periodematiere = Matiere::findOrFail($matiereId)->periodes()->get();

            //dd($periodematiere[0]->date_debut);
            foreach ($periodematiere as $key => $permat){
                //      dd($permat);
               // echo($ensma->nom);
               // echo(" ");
               // echo($permat->date_debut);
               // echo(" ");
               // echo($permat->date_fin);
               // echo('<br><br>');
                $salle = Salle::findOrFail($permat->salle_id)->nom;
                $tabcours= explode("M", $ensma->nom);
                $classe = "M".$tabcours[count($tabcours)-1];
                $horaireDufour = new instancehoraire2();
                $horaireDufour -> id = $permat->id;
                $horaireDufour -> classe = $classe;
                $horaireDufour -> title = $ensma->nom;
                $horaireDufour -> startDate = date('c', $permat->date_debut );
                $horaireDufour -> endDate = date('c', $permat->date_fin );
                $horaireDufour -> localisation = $salle;
                $horaireDufour -> typeEvent = "course";
                $horaireDufour -> description = "";
                $listehoraires[] = $horaireDufour;
            }

        }
        $horaireJSON = json_encode($listehoraires);
       // echo($horaireJSON);
        return $horaireJSON;
    }

}
