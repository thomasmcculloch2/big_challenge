<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientsInfos extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'phone',
        'weight',
        'height',
        'info',
    ];

    public function patient(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class);
    }
}
