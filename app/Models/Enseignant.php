<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Enseignant extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $table = 'enseignants';
    protected $guard = 'enseignant';
    protected $fillable=['nom','prenom', 'email', 'branche'];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getAuthPassword()
    {
      return $this->password;
    }
    public function matieres() {
        return $this->belongsToMany(Matiere::class);

    }
    public function tachespublique() {
        return $this->hasMany(Tache_Publique::class);
    }

}
