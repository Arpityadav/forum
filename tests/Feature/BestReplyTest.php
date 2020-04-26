<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BestReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_creator_of_reply_can_make_any_reply_the_best_reply()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()] );

        $replies = create('App\Reply', ['thread_id' => $thread->id], 2);

        $this->postJson(route('best-reply.store',  [$replies[1]->id]));

        $this->assertTrue($replies[1]->fresh()->isBest());
    }

    /** @test */
    public function an_unauthorized_user_cannot_mark_best_reply()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $replies = create('App\Reply', ['thread_id' => $thread->id], 2);

        $this->postJson(route('best-reply.store',  [$replies[1]->id]))->assertStatus(403);

        $this->assertFalse($replies[1]->fresh()->isBest());
    }
}
