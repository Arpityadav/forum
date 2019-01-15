<?php

namespace App;

trait RecordActivity
{
    public static function bootRecordActivity()
    {
        if (auth()->guest()) return;
        static::created(function ($thread){
            $thread->recordActivity('created');
        });
    }

    protected function recordActivity($event)
    {
        return $this->activity()->create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->id(),
        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    /**
     * @param $event
     * @return string
     */
    protected function getActivityType($event): string
    {
        $type = strtolower(class_basename($this));
        return $event . '_' . $type;
    }
}