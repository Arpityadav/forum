<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_is_notified_if_that_user_is_mentioned()
    {
        //Given two users: JaneDoe and JohnDoe
        $john = create('App\User', [ 'name' => 'JohnDoe']);
        $this->signIn($john);

        $jane = create('App\User', [ 'name' => 'JaneDoe']);

        //If JohnDoe mentions JaneDoe in a thread
        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'user_id' => $john->id,
            'body' => 'See this @JaneDoe @frankDoe'
        ]);

        $this->postJson($thread->path() .'/replies', $reply->toArray());

        //JaneDoe is notified.
        $this->assertCount(1, $jane->notifications);
    }
}
