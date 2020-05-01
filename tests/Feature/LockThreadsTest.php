<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_administrator_may_lock_any_thread()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id() ]);

        $thread->lock();

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => 1
        ])->assertStatus(422);
    }
}
