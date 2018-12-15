<?php

namespace Tests\Unit;

use Tests\Unit\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function answerSave()
    {
        $user = factory(\App\User::class)->make();
        $user->save();
        $question = factory(\App\Question::class)->make();
        $question->user()->associate($user);
        $question->save();
        $answer = factory(\App\Answer::class)->make();
        $answer->user()->associate($user);
        $answer->question()->associate($question);
        $this->assertTrue($answer->save());
    }

    /** @test */
    public function answerUpdate()
    {
        $user = factory(\App\User::class)->create();
        $question = factory(\App\Question::class)->create([
            'user_id' => $user->id,
        ]);
        $answer = factory(\App\Answer::class)->create([
            'question_id' => $question->id,
            'user_id' => $user->id,
        ]);
        $answer->update(['body' => 'Hi, this is the new body']);
        $this->assertTrue(true);
        $this->assertEquals('Hi, this is the new body', $answer->body );

    }

    /** @test */
    public function answerDelete()
    {
        $user = factory(\App\User::class)->create();
        $question = factory(\App\Question::class)->create([
            'user_id' => $user->id,
        ]);
        $answer = factory(\App\Answer::class)->create([
            'question_id' => $question->id,
            'user_id' => $user->id,
        ]);
        $answer->destroy;
        $this->assertTrue(true);
    }
}



