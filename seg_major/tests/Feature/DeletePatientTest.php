<?php

namespace Tests\Feature;

use App\Hospital;
use App\Patient;
use Faker\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class DeletePatientTest extends TestCase
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

    public function create_hospital()
    {
        $hospital = factory(Hospital::class)->make();
        DB::table('hospitals')->insert([
            'hospital_id' => $hospital->hospital_id,
            'name' =>$hospital->name,
        ]);
        return $hospital;

    }

    public function createPatient()
    {
        $hospital = $this->create_hospital();
        DB::table('patients')->insert([
            'forename' => 'Kossai',
            'surname' => 'Sbai',
            'patient_id' => 100,
            'internal_id' => 200,
            'date_of_birth' => '2000-07-01',
            'test_frequency' => 'two-weeks',
            'reviewed' => 'yes',
            'preferred_contact' => 'email',
            'email' => 'kossai.sbai@gmail.com',
            'hospital' => $hospital->hospital_id,
            'sex' => 'M',
            'is_complex' => 'no',
            'received'=>'no'
        ]);
        $patient = DB::table('patients')->get()->first();
        return $patient;
    }


    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_can_successfully_delete_a_patient()
    {
        $patient = $this->createPatient();
        $hospital = DB::table('hospitals')->first();
        $response = $this->get('/patients/delete/'.$patient->patient_id);
        $this->assertDatabaseMissing('patients',['patient_id'=>$patient->patient_id]);
        $response->assertRedirect('patients');
    }


}
