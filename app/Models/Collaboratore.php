<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaboratore extends Model
{
    use HasFactory;

    protected $table = 'collaboratori';

    protected $fillable = [
        'nome',
        'cognome',
        'email',
        'telefono',
        'citta',
        'indirizzo',
        'CAP',
        'intera_giornata',
        'mezza_giornata',
        'giornata_estero',
        'giornata_formazione'
    ];

    public function presenze()
    {
        return $this->hasMany(Presenza::class, 'collaborator_id', 'id');
    }

}
