<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presenza extends Model
{
    use HasFactory;

    protected $table = 'presences';

    protected $fillable = [
        'data_inizio',
        'data_fine',
        'collaborator_id',
        'tipo_di_presenza',
        'luogo',
        'descrizione',
        'spese_rimborso',
        'bonus',
    ];

}
