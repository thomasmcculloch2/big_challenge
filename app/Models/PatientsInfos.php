<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PatientsInfos
 *
 * @property int                             $id
 * @property int|null                        $patient_id
 * @property string                          $info
 * @property string                          $weight
 * @property string                          $height
 * @property string                          $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $patient
 *
 * @method static \Database\Factories\PatientsInfosFactory            factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientsInfos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientsInfos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientsInfos query()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientsInfos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientsInfos whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientsInfos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientsInfos whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientsInfos wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientsInfos wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientsInfos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientsInfos whereWeight($value)
 *
 * @mixin \Eloquent
 */
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

    /**
     * @return BelongsTo<User, PatientsInfos>
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
