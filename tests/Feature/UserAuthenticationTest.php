<?php

namespace Tests\Feature;

use Mockery;
use Laravel\Socialite\Facades\Socialite;
//use Laravel\Socialite\Contracts\Factory as Socialite;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserAuthenticationTest extends TestCase
{
    /** @test */
    public function testRegisterPage()

    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /** @test */
    public function testLoginPage()

    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function testHome()

    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/home');
    }

    /** @test */
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

    /** @test */
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

    /** @test */
    public function userRedirectedToGoogleForGoogleLogin()

    {
        $response = $this->call('GET', '/login/google');

        $this->assertContains('accounts.google.com/o/oauth2', $response->getTargetUrl());
    }

    /** @test */
    public function testUserLoginViaGoogle() {

        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn(str_random(10))
            ->shouldReceive('getEmail')
            ->andReturn(str_random(10) . '@gmail.com')
            ->shouldReceive('getNickname')
            ->andReturn('Pseudo')
            ->shouldReceive('getName')
            ->andReturn('Scarlett Johansson')
            ->shouldReceive('getAvatar')
            ->andReturn('https://en.gravatar.com/userimage');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $this->get('/login/google/callback');
        $this->get('/home');

    }
}
