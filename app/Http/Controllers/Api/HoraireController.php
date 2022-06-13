<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\instancehoraire;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Periode;
use App\Models\Salle;
use App\Models\Tache_Privee;
use App\Models\Tache_Publique;
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
       // dd($request->user());
        if($request->user()->table=="enseignant") {


            $enseignantMatiere = Enseignant::findOrFail($id)->matieres;

            foreach ($enseignantMatiere as $ensma) {
                // echo ($ensma->nom);
                $matiereId = $ensma->id;
                //echo('<br><br>');
                $periodematiere = Matiere::findOrFail($matiereId)->periodes()->get();

                //dd($periodematiere[0]->date_debut);
                foreach ($periodematiere as $key => $permat) {
                    //      dd($permat);
                    // echo($ensma->nom);
                    // echo(" ");
                    // echo($permat->date_debut);
                    // echo(" ");
                    // echo($permat->date_fin);
                    // echo('<br><br>');
                    $salle = Salle::findOrFail($permat->salle_id)->nom;
                    $tabcours = explode("M", $ensma->nom);
                    $classe = "M" . $tabcours[count($tabcours) - 1];
                    $horaireenseignant = new instancehoraire2();
                    $horaireenseignant->id = $permat->id;
                    $horaireenseignant->classe = $classe;
                    $horaireenseignant->title = $ensma->nom;
                    $horaireenseignant->startDate = date('c', $permat->date_debut);
                    $horaireenseignant->endDate = date('c', $permat->date_fin);
                    $horaireenseignant->localisation = $salle;
                    $horaireenseignant->typeEvent = "course";
                    $horaireenseignant->description = "";
                    $listehoraires[] = $horaireenseignant;
                }

            }
        }else{

            $listeIdCours = array();
            $id = $request->user()->id;
            $etudiantmatiere = Eleve::findOrFail($id)->matiere;
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

                    $salleH = Salle::where('id', $cour->salle_id)->get('nom');

                    $horaire = new instancehoraire2();
                    $horaire -> id = $cour->id;
                    $horaire -> classe = $request->user()->classe;
                    $horaire -> title = $listenomcours[$key][0]->nom;
                    $horaire -> startDate = date('c',$cour->date_debut);
                    $horaire -> endDate = date('c',$cour->date_fin);
                    $horaire -> localisation = $salleH[0]->nom;
                    $horaire -> typeEvent = "course";
                    $horaire -> description = "";
                    $listehoraires[] = $horaire;
                }
            }
            //dd($listehoraires);
          //  usort($listehoraires, function($a, $b) {
           //     return $a->startDate - $b->endDate;
          //  });

            $tacheprivee = Tache_Privee::where('id_eleve', 1)->get();

            if(count($tacheprivee)!=0){
                // dd($tacheprivee);
            }
            $tachepublique = array();



            foreach ($listeIdCours as $idcours) {
                $latache = Tache_Publique::where('id_matiere', $idcours)->get();
                if (count($latache) > 0) {
                    $tachepublique[] = Tache_Publique::where('id_matiere', $idcours)->get();
                }


            }
            $listetitretachepublique = array();

            foreach ($tachepublique[0] as $tachepub){
                $matiere = Matiere::where('id', $tachepub->id_matiere);
                dd($matiere);
                $tabcours = explode("M", $matiere->nom);
                $classe = "M" . $tabcours[count($tabcours) - 1];
                dd($classe);
             $horairetachepub = new instancehoraire2();
            $horairetachepub->id = $tachepub->id;
             $horairetachepub->classe = $classe;
            }

            dd($listetitretachepublique);
        }
        $horaireJSON = json_encode($listehoraires);
       // echo($horaireJSON);
        return $horaireJSON;
    }

}
