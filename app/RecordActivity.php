<?php

namespace App;

trait RecordActivity
{
    public static function bootRecordActivity()
    {
        if (auth()->guest()) return;

        foreach (static::getActivitiesToRecord() as $record) {
            static::$record(function ($model) use ($record) {
                $model->recordActivity($record);
            });
        }

        static::deleting(function ($model){
            $model->activity()->delete();
        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
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