<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MissedAppointment extends Mailable
{
    use Queueable, SerializesModels;

    protected $forename;
    protected $testDate;
    protected $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($forename,$testDate,$email)
    {
        $this->forename = $forename;
        $this->testDate = $testDate;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email)->markdown('missed_appointment')->with([
            'forename' => $this->forename,
            'test_date' => $this->testDate,
        ]);
    }

}
