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

class instancehoraire2  // une classe contenant les champs nécessaires au front
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
date_default_timezone_set('Europe/Zurich'); // on définit la timezone
class HoraireController extends Controller
{
//permet de récupérer le nom de la classe, qui est dans le nom de la "matiere" exemple: la matiere: "ProjArtM49-1" rend "M49-1", il aurait été préférable d'ajouter un champ classe dans la table "matiere"
    public function nommatieretonomclasse($nommatiere){
        $tabcours= explode("M", $nommatiere);
        $classe = "M".$tabcours[count($tabcours)-1];
        return $classe;
    }
    //permet de récupérer le nom du cours (maitère dans la base de données) sans la classe exemple: "ProjArtM49-1" rend "ProjArt"
    public function nommatieretonomcours($nommatiere){
        // $nommatfinal = $nommatiere;
        $tabcours= explode("M", $nommatiere);
        $classe = "M".$tabcours[count($tabcours)-1];
        $nommatfinal = str_replace($classe,"",$nommatiere);
        return $nommatfinal;
    }
    //permet de récupérer les horaires spécifiques a une personne
    public function index(Request $request)
    {
        //dans le cas d'un enseignant
        if (Auth::guard('enseignant')->check()) {


            $listehoraires = array();



            $id = Auth::guard('enseignant')->user()->id; //on récupère l'id


            if (count(Enseignant::where("email", Auth::guard('enseignant')->user()->email)->get()) != 0) {

                $enseignantMatiere = Enseignant::findOrFail($id)->matieres; //on récupère les matières (les cours) de l'enseignant

                //on récupère les plages horaires de chaque matières
                foreach ($enseignantMatiere as $ensma) {


                    $matiereId = $ensma->id;

                    $classerecup =$this->nommatieretonomclasse($ensma->nom);

                    $periodematiere = Matiere::findOrFail($matiereId)->periodes()->get();

//pour chaque periodes de chaque matiere, un fihcier json est créer au format demander bar le front
                    foreach ($periodematiere as $key => $permat) {
 // pour enregistré les dates dans la base de données, les dates ont été transformée en timestamp, a ce moment là la timezone était mal défini, et ne tenait visiblement pas compte du décallage horaire ainsi lorsque nous avons modifié le timezone, les dates correspondant a l'heure d'été avait donc une heure de plus. Nous aurions dû re-seeder mais par manque de temps, nous avons opté pour cette solution peu élégante
                        if(date("m", $permat->date_debut) > 03 && date("m", $permat->date_debut) < 10){
                            $decallage= 7200;
                        }else{
                            $decallage = 3600;
                        }
//création du json, il aurait été préférable de mettre dans une fonction mais puisque les json nécessaire ont été créer au fur a mesure, nous ne pensions pas devoir répéter cet opération si souvent
                        $salle = Salle::findOrFail($permat->salle_id)->nom;
                        $tabcours = explode("M", $ensma->nom);
                        $classe = "M" . $tabcours[count($tabcours) - 1];
                        $horaireenseignant = new instancehoraire2();
                        $horaireenseignant->id = $permat->id; //rend l'id de la période
                        $horaireenseignant->classe = $classe; //rend la classe récupérer sur la matière
                        $horaireenseignant->title = $this->nommatieretonomcours($ensma->nom); //correspond au nom de la matière sans la classe
                        $horaireenseignant->startDate = date('c', $permat->date_debut-$decallage); //date de début de la période
                        $horaireenseignant->endDate = date('c', $permat->date_fin-$decallage);
                        $horaireenseignant->localisation = $salle;
                        $horaireenseignant->typeEvent = "course";
                        $horaireenseignant->description = "";
                        $listehoraires[] = $horaireenseignant;
                    }
//on récupère les tâches publiques lorsque la classe de la tahce publique correspond a l'une des classe dans laquelle l'enseignant donne cours
                    $listetachespubliques = Tache_Publique::where('classe', $classerecup)->get();
                    if (count($listetachespubliques) > 0) {
                        foreach ($listetachespubliques as $tachepublique) {
                            if(date("m", $tachepublique->date_debut) > 03 && date("m", $tachepublique->date_debut) < 10){
                                //dd(date('c', $cour->date_debut));
                                $decallage= 7200;
                            }else{
                                $decallage = 3600;
                            }
                            $horairetachepub = new instancehoraire2();
                            $horairetachepub->id = $tachepublique->id;
                            $horairetachepub->classe = $tachepublique->classe;
                            $horairetachepub->title = $tachepublique->titre;
                            $horairetachepub->startDate = date('c', $tachepublique->date-$decallage);
                            $horairetachepub->endDate = date('c', $tachepublique->date + ($tachepublique->duree * 60)-$decallage);
                            $horairetachepub->localisation = "";
                            $horairetachepub->typeEvent = $tachepublique->type;
                            $horairetachepub->description = $tachepublique->description;
                            $listehoraires[] = $horairetachepub;
                        }
                    }


                }
            }
            //tri par ordre chronologique
            usort($listehoraires, function ($a, $b) {
                return strtotime($a->startDate) - strtotime($b->endDate);
            });

            return $listehoraires;
            dd($listehoraires);
            return response()->json($listehoraires);
        }

        // dans le cas ou l'utilisateur est un élève:
        if (Auth::guard('eleve')->check()) {

            $listeIdCours = array();
            $id = $request->user()->id;
            $classeeleve = $request->user()->classe;

            $etudiantmatiere = Eleve::findOrFail($id)->matiere;



            foreach ($etudiantmatiere as $etumat) {

                array_push($listeIdCours, $etumat->id);
                // $periodes = Matiere::where('id',200)->periodes->get;
                // dd($periodes);

                // dd($periodes[0]->date_debut);
            }


            $listeCours = array();
            $listenomcours = array();
            // Nous avons considéré qu'un eleves peut être redoublant par exemple et donc ne pas forcément suivre tous ses cours avec la même classe
            foreach ($listeIdCours as $key => $lid) {
                $listenomcours[$key] = Matiere::where('id', $lid)->get();
                $listeCours[$key] = Periode::with('matiere')
                    ->orderBy('periodes.date_debut', 'asc')
                    ->whereHas('matiere', function ($q) use ($lid) {
                        $q->where('matieres.id', $lid);
                    })->get();

            }


            $listehoraires = array();

            foreach ($listeCours as $key => $cours) {

                foreach ($cours as $cour) {

                    $decallage = 3600;
                    if(date("m", $cour->date_debut) > 03 && date("m", $cour->date_debut) < 10){
                        //dd(date('c', $cour->date_debut));
                        $decallage= 7200;
                    }else{
                        $decallage = 3600;
                    }

                    $salleH = Salle::where('id', $cour->salle_id)->get('nom');

                    $horaire = new instancehoraire2();
                    $horaire->id = $cour->id;
                    $horaire->classe = $request->user()->classe;
                    $horaire->title = $this->nommatieretonomcours($listenomcours[$key][0]->nom);
                    $horaire->startDate = date('c', $cour->date_debut-$decallage);
                    $horaire->endDate = date('c', $cour->date_fin-$decallage);
                    $horaire->localisation = $salleH[0]->nom;
                    $horaire->typeEvent = "course";
                    $horaire->description = "";
                    $listehoraires[] = $horaire;
                }
            }


// pour simplifier, nous avons récupérer uniquement les tâches publique correspondant à la classe attribué par défaut à l'élève mais nous pourrions adapté cela pour les élèves suivant des cours dans différentes classes
            $tachespubliques = Tache_Publique::where("classe", $classeeleve)->get();
            if (count($tachespubliques) > 0) {

                foreach ($tachespubliques as $tachepub) {

                    if(date("m", $tachepub->date_debut) > 03 && date("m", $tachepub->date_debut) < 10){

                        $decallage= 7200;
                    }else{
                        $decallage = 3600;
                    }

                    $horairetachepub = new instancehoraire2();
                    $horairetachepub->id = $tachepub->id;
                    $horairetachepub->classe = $request->user()->classe;
                    $horairetachepub->title = $tachepub->titre;
                    $horairetachepub->startDate = date('c', $tachepub->date-$decallage);
                    $horairetachepub->endDate = date('c', $tachepub->date + ($tachepub->duree * 60)-$decallage); //il aurait été préférable de stocker comme pour les cours date début et date fin
                    $horairetachepub->localisation = "";
                    $horairetachepub->typeEvent = $tachepub->type;
                    $horairetachepub->description = $tachepub->description;
                    $listehoraires[] = $horairetachepub;
                }
            }
            // récupération des tâches privées
            $tachesprivee = Tache_Privee::where("id_eleve", $id)->get();

            if (count($tachesprivee) > 0) {

                foreach ($tachesprivee as $tachepriv) {
                    if(date("m", $cour->date_debut) > 03 && date("m", $cour->date_debut) < 10){
                        //dd(date('c', $cour->date_debut));
                        $decallage= 7200;
                    }else{
                        $decallage = 3600;
                    }
                    $horairetachepriv = new instancehoraire2();
                    $horairetachepriv->id = $tachepriv->id;
                    $horairetachepriv->classe = $request->user()->classe;
                    $horairetachepriv->title = $tachepriv->titre;
                    $horairetachepriv->startDate = date('c', $tachepriv->date-$decallage);
                    $horairetachepriv->endDate = date('c', $tachepriv->date + ($tachepriv->duree * 60)-$decallage);
                    $horairetachepriv->localisation = "";
                    $horairetachepriv->typeEvent = "Perso";
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

//si l'utilisateur n'est pas authentifié
        else {
            return response()->json("Unauthenticated");
        }
    }
    //rend l'horaire ainsi que les tâches publiques de chaque classes
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
                if(date("m", $periode->date_debut) > 03 && date("m", $periode->date_debut) < 10){
                    //dd(date('c', $cour->date_debut));
                    $decallage= 7200;
                }else{
                    $decallage = 3600;
                }
                $horaire = new instancehoraire2();
                $horaire->id = $periode->id;
                $horaire->classe = $classe;
                $horaire->title = $intitulecour;
                $horaire->startDate = date('c', $periode->date_debut-$decallage);
                $horaire->endDate = date('c', $periode->date_fin-$decallage);
                $horaire->localisation = $salle;
                $horaire->typeEvent = "course";
                $horaire->description = "";
                array_push($listeperiodes,$horaire);

            }

        }
        $tachespubliques = Tache_Publique::all();
        if (count($tachespubliques) > 0) {
            foreach ($tachespubliques as $tachepub) {
                if(date("m", $tachepub->date_debut) > 03 && date("m", $tachepub->date_debut) < 10){
                    //dd(date('c', $cour->date_debut));
                    $decallage= 7200;
                }else{
                    $decallage = 3600;
                }

                $horairetachepub = new instancehoraire2();
                $horairetachepub->id = $tachepub->id;
                $horairetachepub->classe = $tachepub->classe;
                $horairetachepub->title = $tachepub->titre;
                $horairetachepub->startDate = date('c', $tachepub->date-$decallage);
                $horairetachepub->endDate = date('c', $tachepub->date + ($tachepub->duree * 60)-$decallage);
                $horairetachepub->localisation = "";
                $horairetachepub->typeEvent = $tachepub->type;
                $horairetachepub->description = $tachepub->description;
                array_push($listeperiodes,$horairetachepub);

            }
        }


        usort($listeperiodes, function ($a, $b) {
            return strtotime($a->startDate) - strtotime($b->endDate);
        });


        return $listeperiodes;
       // return response()->json($listehoraires);
       // return $listeperiodes;
       // return response()->json($listeperiodes);
    }
// permet de récupérer uniquement certains type d'évènement d'une classe en particulier
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
// permet de récupérer certains type d'évènement pour un utilisateur en particulier
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

            array_push($listecompleteaafficher, $listetachespubliques1);

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
// rend toutes les classes
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

