<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function unauthenticated_users_may_not_allow_to_add_reply()
    {
        $this->withoutExceptionHandling()->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('threads/some-channel/1/replies', []);
    }

    /** @test */
    public function a_reply_has_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $reply = make('App\Reply', ['body' => null]);
        $thread = create('App\Thread');

        $this->post($thread->path() .'/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');
        $this->post($thread->path() .'/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }
}
