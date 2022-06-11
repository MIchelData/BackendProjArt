<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Eleve extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    protected $guard = 'eleve';
    protected $table = 'eleves';
    protected $fillable=[
        'nom',
        'prenom',
        'classe',
        'taux_absence',
        'email'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getAuthPassword()
    {
      return $this->password;
    }

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



