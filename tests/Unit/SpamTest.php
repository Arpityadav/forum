<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class SpamTest extends TestCase
{
    /** @test */
    public function it_detects_spam()
    {
        $spam = new \App\Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));
    }
}
