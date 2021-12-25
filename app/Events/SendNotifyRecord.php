<?php
/**
 * Created by PhpStorm.
 * User: tungnt
 * Date: 10/22/19
 * Time: 23:54
 */

namespace Boykioyb\Notify\Events;


use App\Events\Event;
use Boykioyb\Notify\Models\NotificationRecord;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


/**
 * Class SendNotifyRecord
 * @package Boykioyb\Notify\Events
 */
class SendNotifyRecord extends Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var NotificationRecord
     */
    public $id;
    private $notificationRecord;

    /**
     * * SendNotifyRecord constructor.
     * @param NotificationRecord $notificationRecord
     * @param $id
     */
    public function __construct(NotificationRecord $notificationRecord, $id = null)
    {
        $this->notificationRecord = $notificationRecord;
        $this->id = $id;
    }

    /**
     * @return NotificationRecord
     */
    public function getNotificationRecord(): NotificationRecord
    {
        return $this->notificationRecord;
    }

}
