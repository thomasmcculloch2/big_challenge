<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrescriptionAdded extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    private Submission $submission;
    private User $patient;
    private User $doctor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Submission $submission, User $patient, User $doctor)
    {
        $this->submission = $submission;
        $this->patient = $patient;
        $this->doctor = $doctor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Prescription added')->view('emails.prescription', [
            'submission' => $this->submission,
            'patient' => $this->patient,
            'doctor' => $this->doctor
        ]);
    }
}
