<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $fillable=['date_debut', 'date_fin'];

    public function matiere() {
        return $this->belongsTo(Matiere::class);

    }
    public function salle() {
        return $this->belongsTo(Salle::class);

    }
}
