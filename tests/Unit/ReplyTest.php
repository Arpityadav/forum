<?php

namespace Tests\Unit;

use App\Reply;
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

        $reply = new Reply([
            'body' => '@JohnDoe and @JaneDoe'
        ]);

        $this->assertEquals(['JohnDoe', 'JaneDoe'], $reply->mentionedUsers());
    }

    /** @test */
    public function it_wraps_a_mentioned_username_in_a_anchor_tag()
    {
        $reply = new Reply([
            'body' => 'Hey @JohnDoe.'
        ]);

        $this->assertEquals(
            'Hey <a href="/profiles/JohnDoe">@JohnDoe</a>.',
            $reply->body
        );
    }

    /** @test */
    public function it_knows_whether_its_best_reply_or_not()
    {
        $reply = create('App\Reply');

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }

    /** @test */
    public function it_sanitizes_body_automatically()
    {
        $reply = make(Reply::class, [
            'body' => '<script>alert("bad")</script><p>This is okay.</p>'
        ]);

        $this->assertEquals('<p>This is okay.</p>', $reply->body);
    }
}
