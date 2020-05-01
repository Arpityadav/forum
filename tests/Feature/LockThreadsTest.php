<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_admin_may_not_lock_any_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post(route('lock-threads.store', $thread))->assertStatus(403);

        $this->assertFalse(!! $thread->fresh()->locked);
    }

    /** @test */
    public function administrator_can_lock_any_threads()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id() ]);

        $this->post(route('lock-threads.store', $thread))->assertStatus(200);

        $this->assertTrue(!! $thread->fresh()->locked);
    }

    /** @test */
    public function a_locked_thread_may_not_receive_reply()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->lock();

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => 1
        ])->assertStatus(422);
    }
}
