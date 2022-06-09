<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache_Privee extends Model
{
    use HasFactory;

    protected $table = 'taches_privee';
    protected $fillable=['type','date','duree','description','titre','id_eleve'];

    public function eleves() {
        return $this->belongsTo(eleve::class);
    }
}
