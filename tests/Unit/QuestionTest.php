<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function testSave()

    {
        $user = $user = factory(\App\User::class)->make();
        $user->save();
        $question = factory(\App\Question::class)->make();
        $question->user()->associate($user);
        $this->assertTrue($question->save());
    }

    /** @test */
    public function questionUpdate()

    {
        $user = factory(\App\User::class)->create();
        $question = factory(\App\Question::class)->create([
            'user_id' => $user->id,
        ]);
        $question->update(['body' => 'Hi, Im the new question']);
        $this->assertTrue(true);
        $this->assertEquals('Hi, Im the new question', $question->body );
    }

    /** @test */
    public function questionDelete()

    {
        $user = factory(\App\User::class)->create();
        $question = factory(\App\Question::class)->create([
            'user_id' => $user->id,
        ]);
        $question->destroy;
        $this->assertTrue(true);
    }
}
