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

        if (Auth::guard('enseignant')->check()) {


            $listehoraires = array();

            //$id = $request->user()->id;
            $id = Auth::guard('enseignant')->user()->id;

            //  if(Enseignant::where("email",$request->user()->email)->get()){
            //       dd($request->user()->email);
            //   }

            // dd($request->user());
            // dd(count((Enseignant::where("email",$request->user()->email)->get())));
            if (count(Enseignant::where("email", Auth::guard('enseignant')->user()->email)->get()) != 0) {

                $enseignantMatiere = Enseignant::findOrFail($id)->matieres;
                $listeclasses = array();
                foreach ($enseignantMatiere as $ensma) {
                    // echo ($ensma->nom);

                    $matiereId = $ensma->id;
                    array_push($listeclasses, $this->nommatieretonomclasse($ensma));
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
                        $horaireenseignant->title = $this->nommatieretonomcours($ensma->nom);
                        $horaireenseignant->startDate = date('c', $permat->date_debut);
                        $horaireenseignant->endDate = date('c', $permat->date_fin);
                        $horaireenseignant->localisation = $salle;
                        $horaireenseignant->typeEvent = "course";
                        $horaireenseignant->description = "";
                        $listehoraires[] = $horaireenseignant;
                    }
                    $listetachespubliques = Tache_Publique::where('classe', $listeclasses)->get();
                    if (count($listetachespubliques) > 0) {
                        foreach ($listetachespubliques as $tachepublique) {
                            $horairetachepub = new instancehoraire2();
                            $horairetachepub->id = $tachepublique->id;
                            $horairetachepub->classe = $tachepublique->classe;
                            $horairetachepub->title = $tachepublique->titre;
                            $horairetachepub->startDate = date('c', $tachepublique->date);
                            $horairetachepub->endDate = date('c', $tachepublique->date + ($tachepublique->duree * 60));
                            $horairetachepub->localisation = "";
                            $horairetachepub->typeEvent = $tachepublique->type;
                            $horairetachepub->description = $tachepublique->description;
                            $listehoraires[] = $horairetachepub;
                        }
                    }

                    // foreach ($lis)
                }
            }
            usort($listehoraires, function ($a, $b) {
                return strtotime($a->startDate) - strtotime($b->endDate);
            });
           // $horaireJSON = json_encode($listehoraires);
            // echo($horaireJSON);
           // return $horaireJSON;
            return $listehoraires;
            return response()->json($listehoraires);
        }
        if (Auth::guard('eleve')->check()) {

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
                    $horaire->title = $this->nommatieretonomcours($listenomcours[$key][0]->nom);
                    $horaire->startDate = date('c', $cour->date_debut);
                    $horaire->endDate = date('c', $cour->date_fin);
                    $horaire->localisation = $salleH[0]->nom;
                    $horaire->typeEvent = "course";
                    $horaire->description = "";
                    $listehoraires[] = $horaire;
                }
            }



        $tachespubliques = Tache_Publique::where("classe", $classeeleve)->get();
        if (count($tachespubliques) > 0) {
            foreach ($tachespubliques as $tachepub) {
                $horairetachepub = new instancehoraire2();
                $horairetachepub->id = $tachepub->id;
                $horairetachepub->classe = $request->user()->classe;
                $horairetachepub->title = $tachepub->titre;
                $horairetachepub->startDate = date('c', $tachepub->date);
                $horairetachepub->endDate = date('c', $tachepub->date + ($tachepub->duree * 60));
                $horairetachepub->localisation = "";
                $horairetachepub->typeEvent = $tachepub->type;
                $horairetachepub->description = $tachepub->description;
                $listehoraires[] = $horairetachepub;
            }
        }
        $tachesprivee = Tache_Privee::where("id_eleve", $id)->get();
        //dd($tachesprivee);
        if (count($tachesprivee) > 0) {
            foreach ($tachesprivee as $tachepriv) {
                $horairetachepriv = new instancehoraire2();
                $horairetachepriv->id = $tachepriv->id;
                $horairetachepriv->classe = $request->user()->classe;
                $horairetachepriv->title = $tachepriv->titre;
                $horairetachepriv->startDate = date('c', $tachepriv->date);
                $horairetachepriv->endDate = date('c', $tachepriv->date + ($tachepriv->duree * 60));
                $horairetachepriv->localisation = "";
                $horairetachepriv->typeEvent = "privee";
                $horairetachepriv->description = $tachepriv->description;
                $listehoraires[] = $horairetachepriv;
            }
        }
        usort($listehoraires, function ($a, $b) {
            return strtotime($a->startDate) - strtotime($b->endDate);
        });
            //$horaireJSON = json_encode($listehoraires);
            // echo($horaireJSON);
            return $listehoraires;
            return response()->json($listehoraires);
    }


         else {
            return response()->json("Unauthenticated");
        }
    }
    public function horairestouteslesclasses(){

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
        $tachespubliques = Tache_Publique::all();
        if (count($tachespubliques) > 0) {
            foreach ($tachespubliques as $tachepub) {
                $horairetachepub = new instancehoraire2();
                $horairetachepub->id = $tachepub->id;
                $horairetachepub->classe = $tachepub->classe;
                $horairetachepub->title = $tachepub->titre;
                $horairetachepub->startDate = date('c', $tachepub->date);
                $horairetachepub->endDate = date('c', $tachepub->date + ($tachepub->duree * 60));
                $horairetachepub->localisation = "";
                $horairetachepub->typeEvent = $tachepub->type;
                $horairetachepub->description = $tachepub->description;
                array_push($listeperiodes,$horairetachepub);

            }
        }

       // return $listeperiodes;
       // $horaireJSON = json_encode($listeperiodes);
        // echo($horaireJSON);
       // return $horaireJSON;
        usort($listeperiodes, function ($a, $b) {
            return strtotime($a->startDate) - strtotime($b->endDate);
        });
        //$horaireJSON = json_encode($listehoraires);
        // echo($horaireJSON);

        return $listeperiodes;
        return response()->json($listehoraires);
        return $listeperiodes;
        return response()->json($listeperiodes);
    }

    public function selectEventClasse( $classe, $type1 = null, $type2 = null, $type3 = null, $type4 = null){
          $listecoursclasse = $this->horairestouteslesclasses();
          //dd($listecoursclasse[0]->title);
        $listespecifiqueclasse = array();
        foreach($listecoursclasse as $liste){
            if($liste->classe== $classe){
                array_push($listespecifiqueclasse, $liste);
            }
        }
        $listespecifiquetypeevent = array();
            if($type1 != null){
                $listetachespubliques1 = array();
                foreach ($listespecifiqueclasse as $tache){

                    if($tache->typeEvent==$type1){

                        array_push($listetachespubliques1,$tache);
                    }
                }



                // $listetachespubliques2 = Tache_Publique::where('type', $type2)->get();
                array_push($listespecifiquetypeevent, $listetachespubliques1);
            }

        if($type2 != null){
            $listetachespubliques2 = array();
            foreach ($listespecifiqueclasse as $tache){

                if($tache->typeEvent==$type2){

                    array_push($listetachespubliques2,$tache);
                }
            }



            // $listetachespubliques2 = Tache_Publique::where('type', $type2)->get();
            array_push($listespecifiquetypeevent, $listetachespubliques2);
        }
        if($type3 != null){
            $listetachespubliques3 = array();
            foreach ($listespecifiqueclasse as $tache){

                if($tache->typeEvent==$type3){

                    array_push($listetachespubliques3,$tache);
                }
            }



            // $listetachespubliques2 = Tache_Publique::where('type', $type2)->get();
            array_push($listespecifiquetypeevent, $listetachespubliques3);
        }
        if($type4 != null){
            $listetachespubliques4 = array();
            foreach ($listespecifiqueclasse as $tache){

                if($tache->typeEvent==$type4){

                    array_push($listetachespubliques4,$tache);
                }
            }



            // $listetachespubliques2 = Tache_Publique::where('type', $type2)->get();
            array_push($listespecifiquetypeevent, $listetachespubliques4);
        }
        $tableaufinal = array();
        foreach ($listespecifiquetypeevent as $tabcour){
            foreach ($tabcour as $cour){
               array_push($tableaufinal, $cour);
            }
        }

        usort($tableaufinal, function ($a, $b) {
            return strtotime($a->startDate) - strtotime($b->endDate);
        });
        //dd($tableaufinal);
return response()->json($tableaufinal);
    }

    public function selectedEvent(Request $request, $type1 = null, $type2 = null, $type3 = null, $type4 = null){
        $listecomplete = $this->index($request);
        // dd($listecomplete);
$listecompleteaafficher = array();
        if($type1 != null){
$listetachespubliques1 = array();
            foreach ($listecomplete as $tache){

               if($tache->typeEvent==$type1){

                   array_push($listetachespubliques1,$tache);
               }
            }
           // dd($listetachespubliques1);
           // array_push($listecompleteaafficher, $listetachespubliques1);
            //$onlytyp1 = $listecomplete::where('type',$type1)->get();
            //dd($onlytyp1);
          // $listetachespubliques1 = Tache_Publique::where('type', $type1)->get();
           array_push($listecompleteaafficher, $listetachespubliques1);
          // $listetachesprivee = Tache_Privee::where('eleve_id', $request->user()->id)->get();
        }
        if($type2 != null){
            $listetachespubliques2 = array();
            foreach ($listecomplete as $tache){

                if($tache->typeEvent==$type2){

                    array_push($listetachespubliques2,$tache);
                }
            }



           // $listetachespubliques2 = Tache_Publique::where('type', $type2)->get();
            array_push($listecompleteaafficher, $listetachespubliques2);
        }
        if($type3 != null){
            $listetachespubliques3 = array();
            foreach ($listecomplete as $tache){

                if($tache->typeEvent==$type3){

                    array_push($listetachespubliques3,$tache);
                }
            }
            //$listetachespubliques3 = Tache_Publique::where('type', $type3)->get();
            array_push($listecompleteaafficher, $listetachespubliques3);
        }
        if($type4 != null){
            $listetachespubliques4 = array();
            foreach ($listecomplete as $tache){

                if($tache->typeEvent==$type4){

                    array_push($listetachespubliques4,$tache);
                }
            }
            //$listetachespubliques3 = Tache_Publique::where('type', $type3)->get();
            array_push($listecompleteaafficher, $listetachespubliques4);
        }
        $monlist = array();
        foreach ($listecompleteaafficher as $liste){
            foreach ($liste as $t){
                array_push($monlist, $t);
            }
        }
        usort($monlist, function ($a, $b) {
            return strtotime($a->startDate) - strtotime($b->endDate);
        });
        return response()->json($monlist);
       // dd($monlist);
    }

public function Returnclasses(){
        $listeclasse = array();

        $listeeleves = Eleve::all();
    array_push($listeclasse, $listeeleves[0]->classe);
        foreach($listeeleves as $eleve){
            if(in_array($eleve->classe,$listeclasse)){

            }else{
                array_push($listeclasse, $eleve->classe);
            }
    }
        return response()->json($listeclasse);
}

    }

