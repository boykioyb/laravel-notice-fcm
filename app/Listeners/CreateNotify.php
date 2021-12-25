<?php

namespace Boykioyb\Notify\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Boykioyb\Notify\Http\Resources\NotificationResource;


/**
 * Class CreateNotify
 * @package Boykioyb\Notify\Listeners
 */
class CreateNotify
{


    /**
     * @param \Boykioyb\Notify\Events\CreateNotify $event
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function handle(\Boykioyb\Notify\Events\CreateNotify $event)
    {
        $data = \Boykioyb\Notify\Models\Notification::query()->create($event->getData());

        return new NotificationResource($data);
    }
}
