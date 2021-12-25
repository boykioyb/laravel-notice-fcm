<?php

namespace Boykioyb\Notify\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Boykioyb\Notify\Events\CreateNotifyRecord;
use Boykioyb\Notify\Events\SendNotify;
use Boykioyb\Notify\Events\SendNotifyRecord;


/**
 * Class EventServiceProvider
 * @package Boykioyb\Notify\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        CreateNotifyRecord::class => [
            \Boykioyb\Notify\Listeners\CreateNotifyRecord::class
        ],
        SendNotify::class => [
            \Boykioyb\Notify\Listeners\SendNotify::class
        ],
        SendNotifyRecord::class => [
            \Boykioyb\Notify\Listeners\SendNotifyRecord::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
