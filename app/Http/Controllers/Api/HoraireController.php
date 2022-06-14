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
use Illuminate\Support\Facades\Auth;

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
    public function nommatieretonomclasse($nommatiere){
        $tabcours= explode("M", $nommatiere);
        $classe = "M".$tabcours[count($tabcours)-1];
        return $classe;
    }
    public function nommatieretonomcours($nommatiere){
       // $nommatfinal = $nommatiere;
        $tabcours= explode("M", $nommatiere);
        $classe = "M".$tabcours[count($tabcours)-1];
        $nommatfinal = str_replace($classe,"",$nommatiere);
        return $nommatfinal;
    }
    public function index(Request $request)
    {
        if (Auth::check()) {


            $listehoraires = array();
            $id = $request->user()->id;
            //  if(Enseignant::where("email",$request->user()->email)->get()){
            //       dd($request->user()->email);
            //   }

            // dd($request->user());
            // dd(count((Enseignant::where("email",$request->user()->email)->get())));
            if (count(Enseignant::where("email", $request->user()->email)->get()) != 0) {

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
                    // dd($listehoraires);
                }
            } else {

                $listeIdCours = array();
                $id = $request->user()->id;
                $classeeleve = $request->user()->classe;

                $etudiantmatiere = Eleve::findOrFail($id)->matiere;
                //orderBy('nbSecondes','ASC')->get();


                foreach ($etudiantmatiere as $etumat) {

                    array_push($listeIdCours, $etumat->id);
                    // $periodes = Matiere::where('id',200)->periodes->get;
                    // dd($periodes);

                    // dd($periodes[0]->date_debut);
                }


                $listeCours = array();
                $listenomcours = array();
                foreach ($listeIdCours as $key => $lid) {
                    $listenomcours[$key] = Matiere::where('id', $lid)->get();
                    $listeCours[$key] = Periode::with('matiere')
                        ->orderBy('periodes.date_debut', 'asc')
                        ->whereHas('matiere', function ($q) use ($lid) {
                            $q->where('matieres.id', $lid);
                        })->get();

                }
                // usort($array, function($a, $b) {
                //    return strtotime($a['date']) - strtotime($b['date']);
                // });

                $listehoraires = array();

                foreach ($listeCours as $key => $cours) {

                    foreach ($cours as $cour) {

                        $salleH = Salle::where('id', $cour->salle_id)->get('nom');

                        $horaire = new instancehoraire2();
                        $horaire->id = $cour->id;
                        $horaire->classe = $request->user()->classe;
                        $horaire->title = $listenomcours[$key][0]->nom;
                        $horaire->startDate = date('c', $cour->date_debut);
                        $horaire->endDate = date('c', $cour->date_fin);
                        $horaire->localisation = $salleH[0]->nom;
                        $horaire->typeEvent = "course";
                        $horaire->description = "";
                        $listehoraires[] = $horaire;
                    }
                }


            }
            $tachespubliques = Tache_Publique::where("classe",$classeeleve)->get();
            foreach ($tachespubliques as $tachepub){
                $horairetachepub = new instancehoraire2();
                $horairetachepub->id = $tachepub->id;
                $horairetachepub->classe = $request->user()->classe;
                $horairetachepub->title = $tachepub->titre;
                $horairetachepub->startDate = date('c', $tachepub->date);
                $horairetachepub->endDate = date('c', $tachepub->date+($tachepub->duree*60));
                $horairetachepub->localisation = "";
                $horairetachepub->typeEvent = $tachepub->type;
                $horairetachepub->description = $tachepub->description;
                $listehoraires[] = $horairetachepub;
            }
            $tachesprivee = Tache_Privee::where("id_eleve", $id)->get();
            dd($tachesprivee);
            foreach ($tachesprivee as $tachepriv){
                $horairetachepriv = new instancehoraire2();
                $horairetachepriv->id = $tachepriv->id;
                $horairetachepriv->classe = $request->user()->classe;
                $horairetachepriv->title = $tachepub->titre;
                $horairetachepriv->startDate = date('c', $tachepub->date);
                $horairetachepriv->endDate = date('c', $tachepub->date+($tachepub->duree*60));
                $horairetachepriv->localisation = "";
                $horairetachepriv->typeEvent = $tachepub->type;
                $horairetachepriv->description = $tachepub->description;
                $listehoraires[] = $horairetachepub;
            }
            usort($listehoraires, function($a, $b) {
                return strtotime($a->startDate) - strtotime($b->endDate);
            });
            $horaireJSON = json_encode($listehoraires);
            // echo($horaireJSON);
            return $horaireJSON;

        } else {
            return response()->json("Unauthenticated");
        }
    }
    public function horairestouteslesclasses(){
        $i=0;
        $listeperiodes = array();
        $listematieres = Matiere::all();
        foreach ($listematieres as $matiere){
           $periodesmatiere =  $matiere->periodes()->get();
           //dd($periodesmatiere);
            $classe = $this->nommatieretonomclasse($matiere->nom);
           // dd($classe);
            $intitulecour = $this->nommatieretonomcours($matiere->nom);
           // dd($intitulécour);

           foreach ($periodesmatiere as $periode){
$salle = Salle::where('id', $periode->matiere_id)->get();
if(count($salle)==0){
    $salle = "";
}else{
    $salle= $salle[0]->nom;
}
            $i++;
            $horaire = new instancehoraire2();
               $horaire->id = $periode->id;
               $horaire->classe = $classe;
               $horaire->title = $intitulecour;
               $horaire->startDate = date('c', $periode->date_debut);
               $horaire->endDate = date('c', $periode->date_fin);
               $horaire->localisation = $salle;
               $horaire->typeEvent = "course";
               $horaire->description = "";
              array_push($listeperiodes,$horaire);

           }

        }

       // return $listeperiodes;
        $horaireJSON = json_encode($listeperiodes);
        // echo($horaireJSON);
        return $horaireJSON;
    }

    public function selectedEvent($type1 = null, $type2 = null, $type3 = null){
$listecompleteaafficher = array();
        if($type1 != null){
           $listetachespubliques1 = Tache_Publique::where('type', $type1)->get();
           array_push($listecompleteaafficher, $listetachespubliques1);
          // $listetachesprivee = Tache_Privee::where('eleve_id', $request->user()->id)->get();
        }
        if($type2 != null){
            $listetachespubliques2 = Tache_Publique::where('type', $type2)->get();
            array_push($listecompleteaafficher, $listetachespubliques2);
        }
        if($type3 != null){
            $listetachespubliques3 = Tache_Publique::where('type', $type3)->get();
            array_push($listecompleteaafficher, $listetachespubliques3);
        }
        dd($listecompleteaafficher);
    }

    }

