<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable=['nom'];
    public function periodes() {
        return $this->hasMany(Periode::class);

    }
    public function enseignants(){
        return $this->belongsToMany(Enseignant::class);
    }
    public function eleves(){
        return $this->belongsToMany(Eleve::class);
    }

    public function taches() {
        return $this->hasMany(Tache_Publique::class);
    }
}
