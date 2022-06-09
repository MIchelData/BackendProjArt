<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;
    protected $fillable=[
        'nom',
        'prenom',
        'classe',
        'taux_absence',
        'email'
    ];

    public function matiere () {
        return $this->belongsToMany(Matiere::class);
    }
    public function tachespublique() {
        return $this->hasMany(Tache_Publique::class);
    }

    public function tachesprivee() {
        return $this->hasMany(Tache_Privee::class);
    }

}
