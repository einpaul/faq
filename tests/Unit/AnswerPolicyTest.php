<?php

namespace Tests\Unit;

use App\User;
use App\Answer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswerPolicyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function default_user_cannot_update_another_users_answer()

    {
        $user1 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'default',
        ]);
        $question = factory(\App\Question::class)->create(['user_id' => $user1->id,]);
        $answer = factory(\App\Answer::class)->make(['question_id' => $question->id,]);
        $answer->user()->associate($user1);
        $answer->save();
        $user2 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'default',
        ]);
        $this->actingAs($user1);
        $this->assertFalse($user2->can('update', $answer));
    }

    /** @test */
    public function admin_user_can_update_any_answer()

    {
        $user1 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'default',
        ]);
        $question = factory(\App\Question::class)->create(['user_id' => $user1->id,]);
        $answer = factory(\App\Answer::class)->make(['question_id' => $question->id,]);
        $answer->user()->associate($user1);
        $answer->save();
        $user2 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'admin',
        ]);
        $this->actingAs($user1);
        $this->assertTrue($user2->can('update', $answer));
    }

    /** @test */
    public function default_user_cannot_delete_another_users_answer()

    {
        $user1 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'default',
        ]);
        $question = factory(\App\Question::class)->create(['user_id' => $user1->id,]);
        $answer = factory(\App\Answer::class)->make(['question_id' => $question->id,]);
        $answer->user()->associate($user1);
        $answer->save();
        $user2 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'default',
        ]);
        $this->actingAs($user1);
        $this->assertFalse($user2->can('destroy', $answer));
    }

    /** @test */
    public function admin_user_can_delete_any_answer()

    {
        $user1 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'default',
        ]);
        $question = factory(\App\Question::class)->create(['user_id' => $user1->id,]);
        $answer = factory(\App\Answer::class)->make(['question_id' => $question->id,]);
        $answer->user()->associate($user1);
        $answer->save();
        $user2 = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
            'type' => 'admin',
        ]);
        $this->actingAs($user1);
        $this->assertTrue($user2->can('destroy', $answer));
    }
}
