<?php

namespace Tests\Unit;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function an_activity_is_recorded_when_a_thread_is_created()
    {
        $this->signIn();
        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_type' => 'App\Thread',
            'subject_id' => $thread->id,
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function an_activity_is_recorded_when_a_reply_is_created()
    {
        $this->signIn();
        create('App\Reply');

        $this->assertCount(2, Activity::all());
    }
}
