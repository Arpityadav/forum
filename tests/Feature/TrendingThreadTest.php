<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrendingThreadTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp()
    {
        parent::setUp();

        Redis::del('trending_threads');
    }


    /** @test */
    public function it_increment_the_score_by_one_each_time_a_thread_is_visited()
    {
        $this->assertEmpty(Redis::zrevrange('trending_threads', 0, -1));
        $thread = create('App\Thread');

        $this->call('GET', $thread->path());

        $trending = Redis::zrevrange('trending_threads', 0, -1);

        $this->assertCount(1, $trending);

        $this->assertEquals($thread->title, json_decode($trending[0])->title);
    }
}
