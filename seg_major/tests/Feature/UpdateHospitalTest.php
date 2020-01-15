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

class EditHospitalTest extends TestCase
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
            'email'=>$hospital->email,
        ]);
        return $hospital;

    }


    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_can_view_the_form_to_edit_the_hospital()
    {
        $hospital = $this->create_hospital();
        $response = $this->get('/hospital/show/'.$hospital->hospital_id);
        $response->assertSeeText('Edit Hospital');
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_can_successfully_edit_a_hospital()
    {
        $hospital = $this->create_hospital();
        $response = $this->get('/hospital/show/'.$hospital->hospital_id);
        $response =$this->post('/hospital/edit/'.$hospital->hospital_id, [
            'hospital_id' => $hospital->hospital_id,
            'name' => 'UCL College Hospital',
            'contact' => '7278123678',
            'preferred_contact' => 'Email',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('hospitals');
        $this->assertDatabaseHas('hospitals',['contact'=>"7278123678",'name'=>'UCL College Hospital']);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_cannot_edit_a_hospital_with_not_all_required_fields_filled()
    {
        $hospital = $this->create_hospital();
        $response = $this->get('/hospital/show/'.$hospital->hospital_id);
        $response =$this->post('/hospital/edit/'.$hospital->hospital_id, [
            'hospital_id' => $hospital->hospital_id,
            'name' => 'UCL College Hospital',
            'contact' => '7278123678',
        ]);
        $errors = session('errors');
        $this->assertNotNull($errors);
        $this->assertEquals($errors->get('preferred_contact')[0],"The preferred contact field is required.");
        $response->assertRedirect("/hospital/show/".$hospital->hospital_id);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_cannot_edit_a_patient_with_fields_badly_filled()
    {

        $hospital = $this->create_hospital();
        $response = $this->get('/hospital/show/'.$hospital->hospital_id);
        $response =$this->post('/hospital/edit/'.$hospital->hospital_id, [
            'hospital_id' => 'Kossai',
            'name' => 'UCL College Hospital',
            'contact' =>'7278123678' ,
            'preferred_contact' => 'Email',
        ]);
        $errors = session('errors');
        $this->assertNotNull($errors);
        $this->assertEquals($errors->get('hospital_id')[0],"The hospital id must be an integer.");
        $this->assertDatabaseMissing('hospitals',['contact'=>1648643426]);
        $response->assertRedirect('/hospital/show/'.$hospital->hospital_id);
    }




}
