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

        $this->trending = new \App\Trending();

        $this->trending->reset();
    }


    /** @test */
    public function it_increment_the_score_by_one_each_time_a_thread_is_visited()
    {
        $this->assertEmpty($this->trending->get());
        $thread = create('App\Thread');

        $this->call('GET', $thread->path());

        $trending = $this->trending->get();

        $this->assertCount(1, $trending);

        $this->assertEquals($thread->title, $trending[0]->title);
    }
}
