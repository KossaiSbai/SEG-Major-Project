<?php

namespace Tests\Feature;

use App\Hospital;
use Illuminate\Database\QueryException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\DB;

class AddHospitalTest extends TestCase
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

    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_can_view_the_form_to_add_the_patient()
    {
        $response = $this->get('/hospital/new');
        $response->assertSuccessful();
        $response->assertSeeText('New Hospital');
    }


    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_can_successfully_add_a_hospital()
    {
        $hospital = factory(Hospital::class)->make();
        $response = $this->get('/hospital/new');
        $response =$this->post('/hospital/new', [
            'hospital_id' => $hospital->hospital_id,
            'name' => $hospital->name,
            'contact' => '7278123678',
            'preferred_contact' => 'Email',

        ]);
        $response->assertStatus(302);
        $response->assertRedirect('hospitals');
        $this->assertDatabaseHas('hospitals',['hospital_id'=>$hospital->hospital_id,"name"=>$hospital->name]);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_cannot_add_a_hospital_with_not_all_required_fields_filled()
    {
        $hospital = factory(Hospital::class)->make();
        $response = $this->get('/hospital/new');
        $response =$this->post('/hospital/new', [
            'name' => $hospital->name,
            'contact' => '7278123678',
            'preferred_contact' => 'Email',
        ]);
        $errors = session('errors');
        $this->assertNotNull($errors);
        $this->assertEquals($errors->get('hospital_id')[0],"The hospital id field is required.");
        $this->assertDatabaseMissing('hospitals',['hospital_id'=>$hospital->hospital_id]);
        $response->assertRedirect('/hospital/new');
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_cannot_add_a_patient_with_fields_badly_filled()
    {
        $hospital = factory(Hospital::class)->make();
        $response = $this->get('/hospital/new');
        $response =$this->post('/hospital/new', [
            'hospital_id'=>"Invalid",
            'name' => $hospital->name,
            'contact' => '7278123678',
            'preferred_contact' => 'Email',
        ]);
        $errors = session('errors');
        $this->assertNotNull($errors);
        $this->assertEquals($errors->get('hospital_id')[0],"The hospital id must be an integer.");
        $this->assertDatabaseMissing('hospitals',['hospital_id'=>"Invalid"]);
        $response->assertRedirect('/hospital/new');
    }





}
