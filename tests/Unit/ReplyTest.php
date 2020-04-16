<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_an_owner()
    {
        $reply = create('App\Reply');
        $this->assertInstanceOf('App\User', $reply->owner);
    }

    /** @test */
    public function it_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_knows_its_mentioned_users()
    {
        $this->signIn();

        $reply = make('App\Reply', [
            'body' => '@JohnDoe and @JaneDoe'
        ]);

        $this->assertEquals(['JohnDoe', 'JaneDoe'], $reply->mentionedUsers());
    }

    /** @test */
    public function it_wraps_a_mentioned_username_in_a_anchor_tag()
    {
        $reply = make('App\Reply', [
            'body' => 'Hey @JohnDoe.'
        ]);

        $this->assertEquals(
            'Hey <a href="/profiles/JohnDoe">@JohnDoe</a>.',
            $reply->body
        );
    }
}
