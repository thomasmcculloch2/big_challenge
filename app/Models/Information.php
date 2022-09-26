<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Information
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
 * @method static \Database\Factories\InformationFactory            factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Information newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Information newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Information query()
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereWeight($value)
 * @mixin \Eloquent
 */
class Information extends Model
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
     * @return BelongsTo<User, Information>
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
