<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScheduleRequest extends Mailable
{
    use Queueable, SerializesModels;

    protected $forename;
    protected $testDate;
    protected $frequency;
    protected $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($forename,$testDate,$frequency,$email)
    {
        $this->forename = $forename;
        $this->testDate = $testDate;
        $this->frequency = $frequency;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email)->markdown('schedule_appointment')->with([
            'forename' => $this->forename,
            'test_date' => $this->testDate,
            'test_frequency' => $this->frequency,
        ]);
    }

}
