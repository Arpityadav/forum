<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_thread_can_be_searched()
    {
        config(['scout.driver' => 'algolia']);

        $search = 'Foo';

        create('App\Thread', [], 2);
        create('App\Thread', ['body' => "This is ${search} search term."], 2);

        do {
            sleep(.25);

            $response = $this->getJson("/threads/search?q=${search}")->json()['data'];
        } while (empty($response));

        $this->assertCount(2, $response);

        Thread::latest()->take(4)->unsearchable();
    }
}
