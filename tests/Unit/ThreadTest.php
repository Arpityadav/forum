<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function it_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_make_string_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals("/threads/{$thread->channel->slug}/$thread->id", $thread->path());
    }

    /** @test */
    public function it_consist_of_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test */
    public function it_can_add_a_reply()
    {
        $reply = create('App\Reply');
        $user = create('App\User');

        $this->thread->addReply([
            'body' => 'Foo',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = make('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Thread');

        $userId = 1;
        $thread->subscribe($userId);

        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    /** @test */
    public function a_thread_can_be_unsubscribed()
    {
        $thread = create('App\Thread');

        $userId = 1;
        $thread->subscribe($userId);
        $thread->unsubscribe($userId);

        $this->assertEquals(0, $thread->subscriptions()->where('user_id', $userId )->count());
    }

    /** @test */
    public function thread_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        $thread = create('App\Thread');
        $this->signIn();
        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }
}
