<?php

namespace App;

trait RecordsActivity
{
    public static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });

        foreach (static::getRecordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    protected static function getRecordableEvents()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'type' => $this->getActivityTypeName($event),
            'user_id' => auth()->id(),
        ]);
    }

    protected function getActivityTypeName($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
