<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Notification extends Mailable

{
    use Queueable, SerializesModels;

    protected $forename;
    protected $test_date;
    protected $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($forename,$test_date,$email)
    {
        $this->forename = $forename;
        $this->test_date = $test_date;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email)->view('appointment_notification')->with([
            'forename' => $this->forename,
            'test_date' => $this->test_date,
        ]);
    }
}
