<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class AdminTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function default_user_is_not_an_admin()

    {
        $user = factory(User::class)->create();

        $this->assertFalse($user->isAdmin());
    }

    /** @test */
    public function admin_user_is_an_admin()

    {
        $admin = factory(User::class)
            ->create(['type' => 'admin',]);

        $this->assertTrue($admin->isAdmin());
    }

    /** @test */
    public function default_user_cannot_access_the_admin_section()

    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/admin')
            ->assertRedirect('home');
    }

    /** @test */
    public function admin_user_can_access_the_admin_section()
    {
        $admin = factory(User::class)
            ->create(['type' => 'admin',]);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertStatus(200);
    }

}
