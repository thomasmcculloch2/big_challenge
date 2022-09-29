<?php

namespace App\Mail;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrescriptionAdded extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private Submission $submission;
    private string $email;
    private User $patient;
    private User $doctor;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Submission $submission, string $email, User $patient, User $doctor)
    {
        $this->email = $email;
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
