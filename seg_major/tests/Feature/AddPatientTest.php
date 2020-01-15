<?php

namespace Tests\Feature;

use App\Hospital;
use Illuminate\Database\QueryException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class AddPatientTest extends TestCase
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
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_can_view_the_form_to_add_the_patient()
    {
          $response = $this->get('/patients/new');
          $response->assertSuccessful();
          $response->assertSeeText('New Patient');
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_can_successfully_add_a_patient()
    {
        $response = $this->get('/patients/new');
        $hospital = factory(Hospital::class)->create(['hospital_id'=>300]);
        $response =$this->post('/patients/new', [
            'forename' => 'Kossai',
            'surname' => 'Sbai',
            'patient_id' => 100,
            'internal_id' => 200,
            'date_of_birth' => '2000-07-01',
            'test_frequency' => 'two-weeks',
            'reviewed' => 'yes',
            'preferred_contact' => 'email',
            'email' => 'kossai.sbai@gmail.com',
            'contact' => '074298238',
            'hospital' => 300,
            'sex' => 'M',
            'is_complex' => 'no',
            'received'=>'no'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('patients');
        $this->assertDatabaseHas('patients',['forename'=>"Kossai","patient_id"=>100]);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_cannot_add_a_patient_with_not_all_required_fields_filled()
    {
        $response = $this->get('/patients/new');
        $hospital = factory(Hospital::class)->create(['hospital_id'=>300]);
        $response =$this->post('/patients/new', [
            'forename' => 'Kossai',
            'surname' => 'Sbai',
            'date_of_birth' => '2000-07-01',
            'test_frequency' => 'two-weeks',
            'reviewed' => 'yes',
            'preferred_contact' => 'email',
            'email' => 'kossai.sbai@gmail.com',
            'contact' => '074298238',
            'hospital' => 300,
            'sex' => 'M',
            'is_complex'=>'yes'
        ]);
        $errors = session('errors');
        $this->assertNotNull($errors);
        $this->assertEquals($errors->get('patient_id')[0],"The patient id field is required.");
        $this->assertEquals($errors->get('internal_id')[0],"The internal id field is required.");
        $this->assertDatabaseMissing('patients',['forename'=>"Kossai"]);
        $response->assertRedirect('/patients/new');
    }

    /**
 * A basic feature test example.
 * @test
 * @return void
 */
    public function the_user_cannot_add_a_patient_with_fields_badly_filled()
    {
        $response = $this->get('/patients/new');
        $hospital = factory(Hospital::class)->create(['hospital_id'=>300]);
        $response =$this->post('/patients/new', [
            'forename' => 'Kossai',
            'surname' => 'Sbai',
            'patient_id' => 100,
            'internal_id' => 200,
            'date_of_birth' => 20310-3-01,
            'test_frequency' => 'two-weeks',
            'reviewed' => 'yes',
            'contact' => '074298238',
            'preferred_contact' => 'email',
            'email' => 'kossai.sbai@gmail.com',
            'hospital' => 300,
            'sex' => 'M',
            'is_complex' => 'no',
        ]);
        $errors = session('errors');
        $this->assertNotNull($errors);
        $this->assertEquals($errors->get('date_of_birth')[0],"The date of birth is not a valid date.");
        $this->assertDatabaseMissing('patients',['patient_id'=>100]);
        $response->assertRedirect('/patients/new');
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function cannot_create_a_patient_with_an_unexisting_hospital()
    {
        $response = $this->get('/patients/new');
        $hospital = factory(Hospital::class)->create(['hospital_id'=>300]);
        $response =$this->post('/patients/new', [
            'forename' => 'Kossai',
            'surname' => 'Sbai',
            'patient_id' => 100,
            'internal_id' => 200,
            'date_of_birth' => '2000-07-01',
            'test_frequency' => 'two-weeks',
            'reviewed' => 'yes',
            'preferred_contact' => 'email',
            'contact' => '074298238',
            'email' => 'kossai.sbai@gmail.com',
            'hospital' => 200,
            'sex' => 'M',
            'is_complex' => 'no',
            'received'=>'no'
        ]);
        $response->assertStatus(500);
        $this->assertDatabaseMissing('patients',['patient_id'=>100]);

    }



}
