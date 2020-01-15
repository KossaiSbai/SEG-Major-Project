<?php

namespace Tests\Feature\Auth;

use App\User;
use Faker\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\Feature\RegisterTest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase as RefreshDatabase;
class LoginTest extends TestCase
{
   use RefreshDatabase;



    public function registerUser($username,$password)
    {
        $response =$this->post('register', [
            'username' => $username,
            'password' => $password,
            'password_confirmation' => $password,
        ]);
        return $response;
    }


    public function attempt_login($username,$password)
    {
        $response = $this->registerUser($username,$password);
        $response = $this->post('login', [
            'username' => $username,
            'password' => $password,
        ]);
        return $response;
    }

    /**
     *
     * @test
     */
    public function user_can_view_login_form()
    {
        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }


    /**
     *
     * @test
     */
    public function user_can_login()
    {
        $user = Factory(User::class)->make(["username"=>"Kossai","password"=>"kossaisbai","id"=>1]);
        $response = $this->attempt_login($user->username,$user->password);
        $this->assertAuthenticated();
        $response->assertRedirect("home");
    }

    /**
     * An invalid user cannot be logged in.
     *
     * @return void
     */
    public function an_invalid_user_cannot_log_in()
    {
        $user = Factory(User::class)->make(["username"=>"Kossai","password"=>"kossaisbai","id"=>1]);
        $response = $this->attempt_login($user->username,"invalid");
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function an_authenticated_user_can_logout()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/logout');
        $response->assertStatus(302);
        $this->assertGuest();
    }

}
