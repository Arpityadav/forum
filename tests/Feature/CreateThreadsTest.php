<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_user_may_not_be_able_to_create_a_thread()
    {
        $this->withExceptionHandling();

        $this->post('/threads')
            ->assertRedirect('/login');


        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_thread_has_a_title()
    {
        $user = factory('App\User')->create(['email_verified_at' => true ]);

        $this->publishThread(['title' => null], $user)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_has_a_body()
    {
        $user = factory('App\User')->create(['email_verified_at' => true ]);

        $this->publishThread(['body' => null], $user)
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_has_a_valid_channel_id()
    {
        $user = factory('App\User')->create(['email_verified_at' => true ]);

        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null], $user)
                ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999], $user)
                ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function new_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $this->publishThread([], create('App\User', ['email_verified_at' => null]))
            ->assertRedirect('email/verify');
    }

    /** @test */
    public function an_authenticated_user_can_create_a_thread()
    {
        $user = factory('App\User')->create(['email_verified_at' => true ]);

        $this->signIn($user);

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function unauthorized_users_can_can_not_delete_threads()
    {
        $thread = create('App\Thread');

        $this->delete($thread->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($thread->path())
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()] );
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->id,
            'subject_type' => get_class($reply)
        ]);

    }

    public function publishThread($overrides = [], $user = null)
    {
        $this->signIn($user);
        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }


}
