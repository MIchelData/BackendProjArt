<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $fillable=['nom','prenom', 'email', 'branche'];
    public function matieres() {
        return $this->belongsToMany(Matiere::class);

}


}
