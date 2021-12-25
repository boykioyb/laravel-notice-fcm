<?php

namespace Boykioyb\Notify\Events;


use App\Events\Event;
use Boykioyb\Notify\Models\Notification;


/**
 * Class CreateNotifyRecord
 * @package Boykioyb\Notify\Events
 */
class CreateNotifyRecord extends Event
{

    /**
     * @var Notification
     */
    private $notification;

    /**
     * @var array
     */
    private $options = [];

    /**
     * CreateNotifyRecord constructor.
     * @param Notification $notification
     * @param array $options
     */
    public function __construct(Notification $notification, $options = [])
    {
        $this->notification = $notification;
        $this->options = $options;
    }

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        return $this->notification;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }


}
