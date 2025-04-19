<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{
    use HasFactory;

    protected $table = 'creneaux';

    protected $fillable = [
        'doctor_id',
        'date_heure',
        'duree',
    ];

    //  Un créneau appartient à un médecin
    public function medecin()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
