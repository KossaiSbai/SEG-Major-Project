<?php

namespace App\Http\Controllers;

use App\Mail\MissedAppointment;
use App\Mail\Notification;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DateTime;
use App\Mail\ScheduleRequest;

class MailController extends Controller
{
    protected $fromEmail;

    /**
     * Send the schedule request email
     * @param $patient_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function scheduleAppointment($patient_id)
    {
        $patient = Patient::find($patient_id);
            $testDate = new Carbon($patient->test_date);
            Mail::send(new ScheduleRequest($patient->forename,$patient->test_date, $patient->test_frequency,$patient->email));
         return redirect()->back()->with('status-success','Schedule notification successfully sent');
    }

    /**
     * Send the appointment reminder email
     * @param $patient_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function mailNotification($patient_id)
    {
        $patient = Patient::find($patient_id);
        if($patient->email != null) {
            $testDate = new Carbon($patient->test_date);
            $when = $testDate->subWeek();
            Mail::later(10, new Notification($patient->forename,$patient->test_date,$patient->email));
            if($patient->is_complex == 'yes'){
                Mail::later(30, new Notification($patient->forename,$patient->test_date,$patient->email));
            }

        }
        return redirect(route('tests'))->with('status-success','Appointment reminder email on its way');
    }

    /**
     * Send the missed appointment email
     * @param $patient_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function reschedule($patient_id)
    {
        $patient = Patient::find($patient_id);
        Mail::send( new MissedAppointment($patient->forename,$patient->test_date,$patient->email));
        return redirect(route('overdue'))->with('status-success','Missed appointment email successfully sent');
    }

}
