<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_knows_its_last_reply()
    {
        $user = create('App\User');

        $reply = create('App\Reply', [ 'user_id' => $user->id ]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    /** @test */
    public function it_can_determine_the_avatar_path()
    {
        $user = create('App\User');

        $this->assertEquals(asset('avatars/default.png'), $user->avatar_path);

        $user->avatar_path = 'avatars/me.jpg';
        $this->assertEquals(asset('avatars/me.jpg'), $user->avatar_path);
    }
}
