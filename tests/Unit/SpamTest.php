<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class SpamTest extends TestCase
{
    /** @test */
    public function it_checks_for_invalid_keywords()
    {
        $this->withoutExceptionHandling();
        $spam = new Spam;

        $this->assertFalse($spam->detect('Innocent reply here'));

        $this->expectException(\Exception::class);
        $spam->detect('yahoo customer support');
    }

    /** @test */
    public function it_checks_for_any_key_being_held_down()
    {
        $this->withoutExceptionHandling();
        $spam = new Spam;

        $this->expectException(\Exception::class);
        $spam->detect('aaaaa');
    }
}
