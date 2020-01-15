<?php

namespace Tests\Feature;

use App\Mail\MissedAppointment;
use App\Mail\Notification;
use App\Mail\ScheduleRequest;
use App\Patient;
use Faker\Factory;
use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\User;
use App\Hospital;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class MailTest extends TestCase
{

    use RefreshDatabase;

    public function loginWithFakeUser()
    {
        $user = factory(User::class)->create();
        $this->be($user);
    }

    /**
     * A basic feature test example
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->loginWithFakeUser();
    }

    public function testEmail()
    {
        $hospital = factory(Hospital::class)->make();
        DB::table('hospitals')->insert([
            'hospital_id' => $hospital->hospital_id,
            'name' =>$hospital->name,
            'email'=>$hospital->email,
        ]);
        $patient = factory(Patient::class)->make(['email'=>"kossai.sbai@gmail.com",'is_complex'=>'no']);
        DB::table('patients')->insert([
        'patient_id' =>  $patient->patient_id,
        'forename' => $patient->forename,
        'surname' =>  $patient->surname,
        'date_of_birth'=> $patient->date_of_birth,
        'internal_id' =>  $patient->internal_id,
        'sex' => $patient->sex,
        'email' => $patient->email,
        'hospital'=> $patient->hospital,
        'test_date'=> $patient->test_date,
        'is_complex' =>  $patient->is_complex,
        ]);
        Mail::fake();
        $response = $this->get('/email/notification'.$patient->patient_id);
        Mail::assertQueued(Notification::class, 1);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect('bloodtests');

    }


    /**
     * @test
     */
    public function testEmail2()
    {
        $hospital = factory(Hospital::class)->make();
        DB::table('hospitals')->insert([
            'hospital_id' => $hospital->hospital_id,
            'name' =>$hospital->name,
            'email'=>$hospital->email,
        ]);
        $patient = factory(Patient::class)->make(['email'=>"kossai.sbai@gmail.com",'is_complex'=>'no']);
        DB::table('patients')->insert([
            'patient_id' =>  $patient->patient_id,
            'forename' => $patient->forename,
            'surname' =>  $patient->surname,
            'date_of_birth'=> $patient->date_of_birth,
            'internal_id' =>  $patient->internal_id,
            'sex' => $patient->sex,
            'email' => $patient->email,
            'hospital'=> $patient->hospital,
            'test_date'=> $patient->test_date,
            'is_complex' =>  $patient->is_complex,
        ]);
        Mail::fake();
        $response = $this->get('email/scheduleAppointment'.$patient->patient_id);
        Mail::assertSent(ScheduleRequest::class, 1);
        $response->assertSessionHasNoErrors();

    }


    /**
     * @test
     */
    public function testEmail3()
    {
        $hospital = factory(Hospital::class)->make();
        DB::table('hospitals')->insert([
            'hospital_id' => $hospital->hospital_id,
            'name' =>$hospital->name,
            'email'=>$hospital->email,
        ]);
        $patient = factory(Patient::class)->make(['email'=>"kossai.sbai@gmail.com",'is_complex'=>'no']);
        DB::table('patients')->insert([
            'patient_id' =>  $patient->patient_id,
            'forename' => $patient->forename,
            'surname' =>  $patient->surname,
            'date_of_birth'=> $patient->date_of_birth,
            'internal_id' =>  $patient->internal_id,
            'sex' => $patient->sex,
            'email' => $patient->email,
            'hospital'=> $patient->hospital,
            'test_date'=> $patient->test_date,
            'is_complex' =>  $patient->is_complex,
        ]);
        Mail::fake();
        $response = $this->get('/email/missedAppointment'.$patient->patient_id);
        Mail::assertSent(MissedAppointment::class);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect('patients/overdue');

    }
}
