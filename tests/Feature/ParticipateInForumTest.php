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
        $this->post('threads/some-channel/1/replies')
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_reply_has_a_body()
    {
        $this->signIn();

        $reply = make('App\Reply', ['body' => null]);
        $thread = create('App\Thread');

        $this->post($thread->path() .'/replies', $reply->toArray());

        $this->assertDatabaseMissing('replies', $reply->toArray());
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');
        $this->post($thread->path() .'/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);

        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /** @test */
    public function unauthorized_users_cannot_delete_a_reply()
    {
        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_a_reply()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $response = $this->delete("/replies/{$reply->id}");
        $response->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /** @test */
    public function authorized_users_can_edit_a_reply()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updated_reply = "Updated!";
        $response = $this->patch("/replies/{$reply->id}", ['body' => $updated_reply]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updated_reply]);
    }

    /** @test */
    public function unauthorized_users_cannot_edit_a_reply()
    {
        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn();

        $this->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function reply_that_contain_spam_words_are_not_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => 'Yahoo Customer Support'
        ]);

        $this->postJson($thread->path() .'/replies', $reply->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function users_can_only_leave_one_reply_in_a_minute()
    {
        $this->signIn();
       $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => 'A normal reply',
        ]);

        $this->post($thread->path() .'/replies', $reply->toArray())
            ->assertStatus(201);

        $this->post($thread->path() .'/replies', $reply->toArray())
            ->assertStatus(429);
    }
}
