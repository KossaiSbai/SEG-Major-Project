<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\DB as DB;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    public function register_user($username,$password)
    {
        $this->get('/register');
        $response = $this->post('register', [
            'username' => $username,
            'password' => $password,
            'password_confirmation' => $password,
        ]);
        return $response;
    }

    /**
     *
     * @test
     */
    public function user_can_view_register_form()
    {
        $response = $this->get('/register');
        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }


    /** @test */
    public function testRegistersAValidUser()
    {
        $user = factory(User::class)->make();
        $response = $this->register_user($user->username,$user->password);
        $response->assertStatus(302);
        $this->assertGuest();
        $this->assertNotNull(DB::table('users')->where('username',$user->username));

    }

    /**
     * An invalid user is not registered.
     *
     * @return void
     */
    public function testDoesNotRegisterAnInvalidUser()
    {
        $user = factory(User::class)->make();
        $response = $this->register_user($user->username,'invalid');
        $response->assertSessionHasErrors();
        $response->assertRedirect('/register');
    }



}
