<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;
    protected $table = 'rendez_vous';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date_heure',
        'motif',
    ];

   
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    
    public function medecin()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
