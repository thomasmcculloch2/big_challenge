<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Submission
 *
 * @property int                             $id
 * @property int|null                        $doctor
 * @property int                             $patient
 * @property string                          $title
 * @property string                          $symptoms
 * @property string                          $status
 * @property string|null                     $prescription
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\SubmissionFactory            factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission wherePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission wherePrescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereSymptoms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient',
        'title',
        'symptoms',
        'status',
        'doctor'
    ];

    /**
     * @return BelongsTo<User, Submission>
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient');
    }

    /**
     * @return BelongsTo<User, Submission>
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor');
    }
}
