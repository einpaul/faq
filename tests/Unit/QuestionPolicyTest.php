<?php

namespace Tests\Unit;

use App\User;
use App\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class QuestionPolicyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function default_user_cannot_update_another_users_question()

    {
        $user1 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'default',
        ]);
        $question = factory(\App\Question::class)->make();
        $question->user()->associate($user1);
        $question->save();
        $user2 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'default',
        ]);
        $this->actingAs($user1);
        $this->assertFalse($user2->can('update', $question));
    }

    /** @test */
    public function admin_user_can_update_any_question()

    {
        $user1 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'default',
        ]);
        $question = factory(\App\Question::class)->make();
        $question->user()->associate($user1);
        $question->save();
        $user2 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'admin',
        ]);
        $this->actingAs($user1);
        $this->assertTrue($user2->can('update', $question));
    }

    /** @test */
    public function default_user_cannot_delete_another_users_question()

    {
        $user1 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'default',
        ]);
        $question = factory(\App\Question::class)->make();
        $question->user()->associate($user1);
        $question->save();
        $user2 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'default',
        ]);
        $this->actingAs($user1);
        $this->assertFalse($user2->can('destroy', $question));
    }

    /** @test */
    public function admin_user_can_delete_any_question()

    {
        $user1 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'default',
        ]);
        $question = factory(\App\Question::class)->make();
        $question->user()->associate($user1);
        $question->save();
        $user2 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'admin',
        ]);
        $this->actingAs($user1);
        $this->assertTrue($user2->can('delete', $question));
    }
}
