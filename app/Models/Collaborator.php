<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;

    protected $table = 'collaborators';

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
}
