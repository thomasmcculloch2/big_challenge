<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientsInfos extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'weight',
        'height',
        'info',
        'patient_id'
    ];
    public function patient()
    {
        return $this->hasOne(User::class);
    }
}
