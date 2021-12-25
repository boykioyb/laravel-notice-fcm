<?php


namespace Boykioyb\Notify\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Boykioyb\Notify\Events\CreateNotifyRecord;
use Boykioyb\Notify\Http\Controllers\Base;
use Boykioyb\Notify\Http\Requests\StoreNotifyRequest;
use Boykioyb\Notify\Http\Resources\NotificationResource;
use Boykioyb\Notify\Models\Notification;
use Boykioyb\Notify\Models\NotificationDevice;
use Boykioyb\Notify\Models\NotificationRecord;
use Boykioyb\Notify\Services\Common\HashID;
use Boykioyb\Notify\Services\Common\Paginate;
use Boykioyb\Notify\Services\Common\Response;

/**
 * Class Notify
 * @package Boykioyb\Notify\Http\Controllers
 */
class Notify extends Base
{

    /**
     * @var NotificationResource $notificationResource
     */
    private $notificationResource;
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $notificationRecordResource;
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $notificationDeviceResource;

    /**
     * Notify constructor.
     */
    public function __construct()
    {
        $this->notificationResource = \Boykioyb\Notify\Services\Common\Notify::getNotificationResource();
        $this->notificationRecordResource = \Boykioyb\Notify\Services\Common\Notify::getNotificationRecordResource();
        $this->notificationDeviceResource = \Boykioyb\Notify\Services\Common\Notify::getNotificationDeviceResource();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = !empty($request->per_page) ? $request->per_page : 25;

        $notifications = Notification::query()
            ->orderBy('created_at', 'desc');

        $notifications = $notifications->paginate($perPage);

        return Response::success([
            'notifications' => $this->notificationResource::collection($notifications),
            'meta_data' => Paginate::getMetaData($notifications)
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function records(Request $request, $id)
    {
        $perPage = !empty($request->per_page) ? $request->per_page : 25;

        $notifications = NotificationRecord::query()
            ->with(['device'])
            ->where('notification_id', $id)
            ->orderBy('created_at', 'desc');

        $notifications = $notifications->paginate($perPage);

        return Response::success([
            'notification_records' => $this->notificationRecordResource::collection($notifications),
            'meta_data' => Paginate::getMetaData($notifications)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function devices(Request $request)
    {
        $perPage = !empty($request->per_page) ? $request->per_page : 25;

        $notificationDevices = NotificationDevice::query()
            ->orderBy('created_at', 'desc');

        if (!empty($request->token)) {
            $notificationDevices->where('token', $request->token);
        }

        if (!empty($request->platform)) {
            $notificationDevices->where('platform', $request->platform);
        }

        if (!empty($request->user_id)) {
            $notificationDevices->where('user_id', $request->user_id);
        }

        $notificationDevices = $notificationDevices->paginate($perPage);

        return Response::success([
            'notification_devices' => $this->notificationDeviceResource::collection($notificationDevices),
            'meta_data' => Paginate::getMetaData($notificationDevices)
        ]);
    }

    /**
     * @param StoreNotifyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreNotifyRequest $request)
    {
        $user = $request->user();

        $attributes = $request->only([
            'title',
            'description',
            'receiver_type',
            'receiver_id',
            'action',
            'content',
            'send_data',
        ]);

        if (!empty($attributes['receiver_type'])
            && $attributes['receiver_type'] == \Boykioyb\Notify\Services\Common\Notify::RECEIVER_TYPE_ALL) {
            $attributes['receiver_id'] = 0;
        } elseif (!empty($attributes['receiver_type'])
            && $attributes['receiver_type'] == \Boykioyb\Notify\Services\Common\Notify::RECEIVER_TYPE_USER
            && !empty($attributes['receiver_id'])) {
            $attributes['receiver_id'] = HashID::idDecode($attributes['receiver_id']);
        }

        $attributes['creator_type'] = !empty($request->creator_type) ? $request->creator_type : \Boykioyb\Notify\Services\Common\Notify::CREATOR_TYPE_USER;
        $attributes['creator_id'] = $user->id;

        $notification = \Boykioyb\Notify\Models\Notification::query()->create($attributes);

        return Response::success([
            'notification' => new $this->notificationResource($notification)
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $notification = Notification::query()->where('id', $id)->first();

        if (!$notification instanceof Notification) {
            return Response::error(config('notification.error_code.notification_notfound', 1000), 'Notification not found.');
        }

        return Response::success([
            'notification' => new $this->notificationResource($notification)
        ]);
    }

    /**
     * @param StoreNotifyRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreNotifyRequest $request, $id)
    {
        $notification = Notification::query()->where('id', $id)->first();

        if (!$notification instanceof Notification) {
            return Response::error(config('notification.error_code.notification_notfound', 1000), 'Notification not found.');
        }

        if (in_array($notification->status, [
            \Boykioyb\Notify\Services\Common\Notify::STATUS_APPROVED,
            \Boykioyb\Notify\Services\Common\Notify::STATUS_PROCESSING,
            \Boykioyb\Notify\Services\Common\Notify::STATUS_SUCCESS
        ])) {
            return Response::error(config('notification.error_code.notification_is_approved', 1000), 'Notification is approved.');
        }

        $attributes = $request->only([
            'title',
            'description',
            'receiver_type',
            'receiver_id',
            'action',
            'content',
            'send_data',
        ]);

        if ($attributes['receiver_type'] == \Boykioyb\Notify\Services\Common\Notify::RECEIVER_TYPE_ALL) {
            $attributes['receiver_id'] = 0;
        } elseif ($attributes['receiver_type'] == \Boykioyb\Notify\Services\Common\Notify::RECEIVER_TYPE_USER && !empty($attributes['receiver_id'])) {
            $attributes['receiver_id'] = HashID::idDecode($attributes['receiver_id']);
        }

        $notification->update($attributes);

        return Response::success([
            'notification' => new $this->notificationResource($notification)
        ]);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve(Request $request, $id)
    {
        $notification = Notification::query()->where('id', $id)->first();

        if (!$notification instanceof Notification) {
            return Response::error(config('notification.error_code.notification_notfound', 1000), 'Notification not found.');
        }

        if (in_array($notification->status, [
            \Boykioyb\Notify\Services\Common\Notify::STATUS_APPROVED,
            \Boykioyb\Notify\Services\Common\Notify::STATUS_PROCESSING,
            \Boykioyb\Notify\Services\Common\Notify::STATUS_SUCCESS
        ])) {
            return Response::error(config('notification.error_code.notification_is_approved', 1000), 'Notification is approved.');
        }

        $user = $request->user();

        $attributes = $request->only([
            'title',
            'description',
            'receiver_type',
            'receiver_id',
            'action',
            'content',
            'send_data',
        ]);

        if (!empty($attributes['receiver_type'])
            && $attributes['receiver_type'] == \Boykioyb\Notify\Services\Common\Notify::RECEIVER_TYPE_ALL) {
            $attributes['receiver_id'] = 0;
        } elseif (!empty($attributes['receiver_type'])
            && $attributes['receiver_type'] == \Boykioyb\Notify\Services\Common\Notify::RECEIVER_TYPE_USER
            && !empty($attributes['receiver_id'])) {
            $attributes['receiver_id'] = HashID::idDecode($attributes['receiver_id']);
        }
        $attributes['moderator_id'] = $user->id;
        $attributes['status'] = \Boykioyb\Notify\Services\Common\Notify::STATUS_APPROVED;

        if (!$notification->update($attributes)) {
            return Response::error(config('notification.error_code.notification_is_not_approved', 1000), 'Notification is not approved.');
        }

        $notificationInfoClass = \Boykioyb\Notify\Services\Common\Notify::getNotificationInfo();
        /**
         * @var \Boykioyb\Notify\Services\Notification $notificationInfo
         */
        $notificationInfo = new $notificationInfoClass(
            $notification->title,
            $notification->description,
            $notification->action
        );
        $notification->send_data = $notificationInfo->getSendData();
        $notification->save();

        event(new CreateNotifyRecord($notification));

        return Response::success([
            'notification' => new $this->notificationResource($notification)
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $notification = Notification::query()->where('id', $id)->first();

        if (!$notification instanceof Notification) {
            return Response::error(config('notification.error_code.notification_notfound', 1000), 'Notification not found.');
        }

        if (in_array($notification->status, [
            \Boykioyb\Notify\Services\Common\Notify::STATUS_APPROVED,
            \Boykioyb\Notify\Services\Common\Notify::STATUS_PROCESSING,
            \Boykioyb\Notify\Services\Common\Notify::STATUS_SUCCESS
        ])) {
            return Response::error(config('notification.error_code.notification_is_approved', 1000), 'Notification is approved.');
        }

        if ($notification->delete()) {
            NotificationRecord::query()->where('notification_id', $notification->id)->delete();
        }

        return Response::success();
    }
}
