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

class EditPatientTest extends TestCase
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

    /**
     * @return mixed
     */
    public function create_hospital()
    {
        $hospital = factory(Hospital::class)->make();
        DB::table('hospitals')->insert([
            'hospital_id' => $hospital->hospital_id,
            'name' =>$hospital->name,
        ]);
        return $hospital;

    }

    /**
     * @return mixed
     */
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
    public function the_user_can_view_the_form_to_add_the_patient()
    {
        $patient = $this->createPatient();
        $response = $this->get('/patients/show/'.$patient->patient_id);
        $response->assertSeeText('Edit Patient');
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_can_successfully_edit_a_patient()
    {
        $patient = $this->createPatient();
        $response = $this->get('/patients/show/'.$patient->patient_id);
        $hospital = DB::table('hospitals')->first();
        $response =$this->post('/patients/edit/'.$patient->patient_id, [
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
            'received'=>'no',
            'test_date' => '2019-03-30',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('patients');
        $this->assertDatabaseHas('patients',['test_date'=>"2019-03-30"]);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_cannot_edit_a_patient_with_not_all_required_fields_filled()
    {
        $patient = $this->createPatient();
        $response = $this->get('/patients/show/'.$patient->patient_id);
        $hospital = DB::table('hospitals')->first();
        $response =$this->post('/patients/edit/'.$patient->patient_id, [
            'forename' => 'Kossai',
            'surname' => 'Sbai',
            'date_of_birth' => '2000-07-01',
            'test_frequency' => 'two-weeks',
            'reviewed' => 'yes',
            'preferred_contact' => 'email',
            'email' => 'kossai.sbai@gmail.com',
            'hospital' => $hospital->hospital_id,
            'sex' => 'M',
            'is_complex'=>'yes'
        ]);
        $errors = session('errors');
        $this->assertNotNull($errors);
        $this->assertEquals($errors->get('patient_id')[0],"The patient id field is required.");
        $this->assertEquals($errors->get('internal_id')[0],"The internal id field is required.");
        $response->assertRedirect("/patients/show/".$patient->patient_id);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_cannot_edit_a_patient_with_fields_badly_filled()
    {
        $patient = $this->createPatient();
        $response = $this->get('/patients/show/'.$patient->patient_id);
        $hospital = DB::table('hospitals')->first();
        $response =$this->post('/patients/edit/'.$patient->patient_id, [
            'forename' => 'Kossai',
            'surname' => 'Sbai',
            'patient_id' => 100,
            'internal_id' => 200,
            'date_of_birth' => 2013-03-01,
            'test_frequency' => 'two-weeks',
            'reviewed' => 'yes',
            'preferred_contact' => 'email',
            'email' => 'kossai.sbai@gmail.com',
            'hospital' => $hospital->hospital_id,
            'sex' => 'M',
            'is_complex' => 'no',
        ]);
        $errors = session('errors');
        $this->assertNotNull($errors);
        $this->assertEquals($errors->get('date_of_birth')[0],"The date of birth is not a valid date.");
        $this->assertDatabaseMissing('patients',['date_of_birth'=>2013-03-01]);
        $response->assertRedirect('/patients/show/'.$patient->patient_id);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function cannot_create_a_patient_with_an_unexisting_hospital()
    {

        $patient = $this->createPatient();
        $response = $this->get('/patients/show/'.$patient->patient_id);
        $response =$this->post('/patients/edit/'.$patient->patient_id, [
            'forename' => 'Kossai',
            'surname' => 'Sbai',
            'patient_id' => 100,
            'internal_id' => 200,
            'date_of_birth' => '2000-07-01',
            'test_frequency' => 'two-weeks',
            'reviewed' => 'yes',
            'preferred_contact' => 'email',
            'email' => 'kossai.sbai@gmail.com',
            'hospital' => 200,
            'sex' => 'M',
            'is_complex' => 'no',
            'received'=>'no'
        ]);
        $this->assertNotNull($response->exception);

    }


//    /**
//     * @test
//     * @return void
//     */
//    public function changeTestDate()
//    {
//        $patient = $this->createPatient();
//        $response = $this->post('/bloodtests/modify/'.$patient->test_date."0",[
//            'test_date' => '2019-03-31',
//            'test_frequency'=>$patient->test_frequency
//        ]);
//    }


}
