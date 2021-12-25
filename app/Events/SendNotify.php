<?php

namespace Boykioyb\Notify\Events;


use App\Events\Event;
use Boykioyb\Notify\Services\Notification;


/**
 * Class SendNotify
 * @package Boykioyb\Notify\Events
 */
class SendNotify extends Event
{
    /**
     * @var
     */
    private $userId;

    /**
     * @var Notification|null
     */
    private $data = null;


    /**
     * SendNotify constructor.
     * @param $userId
     * @param $data
     * @throws \Exception
     */
    public function __construct($userId, $data)
    {
        $this->userId = $userId;

        if ($data instanceof Notification || is_subclass_of($data, Notification::class)) {
            $this->data = $data;
        } else {
            throw new \Exception("Notification info is not valid!");
        }
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }


    /**
     * @return Notification|null
     */
    public function getData()
    {
        return $this->data;
    }


}
