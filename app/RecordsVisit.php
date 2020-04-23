<?php

namespace App;

use Illuminate\Support\Facades\Redis;

trait RecordsVisit
{
    public function visitsCount()
    {
        return Redis::get($this->visitsCacheKey()) ?? 0;
    }

    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());

        return $this;
    }

    public function visitsCacheKey()
    {
        return "threads.{$this->id}.visits";
    }

    public function resetVisits()
    {
        Redis::del($this->visitsCacheKey());
    }
}
