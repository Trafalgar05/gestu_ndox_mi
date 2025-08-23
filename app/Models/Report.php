<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'type_probleme',
        'description',
        'latitude',
        'longitude',
        'adresse',
        'statut',
    ];
}