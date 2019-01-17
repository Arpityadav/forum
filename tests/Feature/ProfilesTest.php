<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_user_has_a_profile()
    {
        $this->withoutExceptionHandling();
        $user = create('App\User');

        $this->get("profiles/{$user->name}")
            ->assertSee($user->name);
    }
    
    /** @test */
    public function profile_display_all_threads_associated_to_user()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->get("/profiles/" . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
