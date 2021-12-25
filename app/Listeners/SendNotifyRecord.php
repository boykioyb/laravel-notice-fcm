<?php

namespace Boykioyb\Notify\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Boykioyb\Notify\Models\NotificationDevice;
use Boykioyb\Notify\Models\NotificationRecord;
use Boykioyb\Notify\Services\Common\HashID;
use Boykioyb\Notify\Services\Common\Notify;
use Boykioyb\Notify\Services\Contract\Notification;


/**
 * Class SendNotifyRecord
 * @package Boykioyb\Notify\Listeners
 */
class SendNotifyRecord implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    public $afterCommit = true;

    protected $notifyRecord;

    private $log;

    /**
     * Create a new job instance.
     *
     */
    public function __construct()
    {
        $this->log = Log::channel('notification');
        $this->delay(10);
    }


    public function handle(\Boykioyb\Notify\Events\SendNotifyRecord $event)
    {
        $this->notifyRecord = $event;

        $notificationRecord = $this->notifyRecord->getNotificationRecord();

        $this->log->info('Line 53 prepare send notify: ', [
            'NotificationRecord' => $event
        ]);

        if (!$notificationRecord instanceof NotificationRecord) {
            if ($event->id) {
                $notificationRecord = NotificationRecord::find($event->id);
            }
        }

        if (!$notificationRecord instanceof NotificationRecord) {
            $this->log->info('Line 64 NotificationRecord not found: ', [
                'NotificationRecord' => $event
            ]);
            return;
        }

        $notification = $notificationRecord->notification;
        if (!$notification instanceof \Boykioyb\Notify\Models\Notification) {
            $notificationRecord->update([
                'status' => Notify::STATUS_RECORD_NOTIFICATION_NOT_FOUND
            ]);

            return;
        }

        $notificationDevice = $notificationRecord->device;
        if (!$notificationDevice instanceof NotificationDevice) {
            $notificationRecord->update([
                'status' => Notify::STATUS_RECORD_DEVICE_NOT_EXISTS
            ]);

            return;
        }

        $notificationRecord->update([
            'status' => Notify::STATUS_RECORD_PROCESSING
        ]);

        $notificationService = app()->make(Notification::class);

        $sendData = (array)json_decode($notification->send_data);
        $sendData = array_merge([
            'id' => HashID::idEncode($notificationRecord->id),
            'body' => $notification->description,
        ], $sendData);

        $this->log->info('Line 91 send notify: ', [
            'sendData' => $sendData
        ]);

        $sendInfo = $notificationService->send($notificationDevice->token, [
            'notification' => $sendData
        ]);

        if (!empty($sendInfo['error'])) {
            $notificationRecord->update([
                'status' => Notify::STATUS_RECORD_FAIL,
                'meta_data' => json_encode($sendInfo)
            ]);

            return;
        }

        $notificationRecord->update([
            'status' => Notify::STATUS_RECORD_SUCCESS,
            'meta_data' => json_encode($sendInfo)
        ]);
    }
}
