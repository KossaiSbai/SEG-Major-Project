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

class DeleteHospitalTest extends TestCase
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

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_cannot_delete_a_hospital_if_it_has_a_patient()
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
        $response = $this->get('/hospitals/delete/'.$hospital->hospital_id);
        $response->assertStatus(500);
        $this->assertDatabaseHas('hospitals',['hospital_id'=>$hospital->hospital_id]);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function the_user_can_successfully_delete_a_patient()
    {
        $hospital = $this->create_hospital();
        $response = $this->get('/hospitals/delete/'.$hospital->hospital_id);
        $response->assertStatus(302);
        $response->assertRedirect('hospitals');
        $this->assertDatabaseMissing('hospitals',['hospital_id'=>$hospital->hospital_id]);
    }


}
