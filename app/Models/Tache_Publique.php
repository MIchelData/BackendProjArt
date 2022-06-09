<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache_Publique extends Model
{
    use HasFactory;
<<<<<<< Updated upstream

    protected $table = 'taches_publique';
    protected $fillable=['type','date','duree','description','titre','id_enseignant'];
=======
    //proteger la table
    protected $table = 'taches_publiques';
    protected $fillable=['type','date','duree','description','titre','id_enseignant','id_eleve'];
>>>>>>> Stashed changes

    public function matieres() {
        return $this->belongsToMany(Matiere::class);
    }

    public function enseignants() {
        return $this->belongsTo(Enseignant::class);
    }
    public function eleves() {
        return $this->belongsTo(eleve::class);
    }
    public function taches(){
        return $this->belongsTo(Matiere::class);
    }



}
