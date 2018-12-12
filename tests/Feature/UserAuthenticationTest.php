<?php

namespace Tests\Feature;

use Mockery;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\Factory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserAuthenticationTest extends TestCase
{

    public function testRegisterPage()

    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function testLoginPage()

    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testHome()

    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/home');
    }

    public function testUserCanLoginWithCorrectCredentials()

    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithIncorrectPassword()

    {
        $user = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
        ]);
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testSocialiteGoogleUser()

    {
        $googleuser = Mockery::mock('Laravel\Socialite\Two\User');

        $googleuser
            ->shouldReceive('getId')
            ->andReturn(rand())
            ->shouldReceive('getName')
            ->andReturn(str_random(10))
            ->shouldReceive('getEmail')
            ->andReturn(str_random(10) . '@gmail.com')
            ->shouldReceive('getAvatar')
            ->andReturn('https://en.gravatar.com/userimage');

        Socialite::shouldReceive('driver->user')->andReturn($googleuser);

        $this->get('/login/google/callback');
        $this->get('/home');
    }

}
