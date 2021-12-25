<?php

namespace Boykioyb\Notify\Http\Controllers;


use Illuminate\Http\Request;
use Boykioyb\Notify\Http\Resources\NotificationUserResource;
use Boykioyb\Notify\Models\NotificationRecord;
use Boykioyb\Notify\Services\Common\Paginate;
use Boykioyb\Notify\Services\Common\Response;

/**
 * Class Notify
 * @package Boykioyb\Notify\Http\Controllers
 */
class Notify extends Base
{
    /**
     * @var NotificationUserResource $notificationUserResource
     */
    private $notificationUserResource;

    /**
     * Notify constructor.
     */
    public function __construct()
    {
        $this->notificationUserResource = \Boykioyb\Notify\Services\Common\Notify::getNotificationUserResource();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $perPage = !empty($request->per_page) ? $request->per_page : 25;

        $notifications = NotificationRecord::query()
            ->where('user_id', $user->id)
            //->where('status', \Boykioyb\Notify\Services\Common\Notify::STATUS_SUCCESS)
            ->orderBy('created_at', 'desc');

        $notifications = $notifications->paginate($perPage);

        $totalNotRead = NotificationRecord::query()
            ->where('user_id', $user->id)
            ->where('is_read', 0)
            ->count();

        return Response::success([
            'notifications' => $this->notificationUserResource::collection($notifications),
            'total_not_read' => $totalNotRead,
            'meta_data' => Paginate::getMetaData($notifications)
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        $notification = NotificationRecord::query()
            ->where('id', $id)
            ->where('user_id', $user->id)
            //->where('status', \Boykioyb\Notify\Services\Common\Notify::STATUS_SUCCESS)
            ->first();

        if (!$notification instanceof NotificationRecord) {
            return Response::error(config('notification.error_code.notification_notfound', 1000), 'Notification not found.');
        }

        return Response::success([
            'notification' => new $this->notificationUserResource($notification)
        ]);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function read(Request $request, $id)
    {
        $user = $request->user();

        $notification = NotificationRecord::query()
            ->where('id', $id)
            ->where('user_id', $user->id)
            //->where('status', \Boykioyb\Notify\Services\Common\Notify::STATUS_SUCCESS)
            ->first();

        if (!$notification instanceof NotificationRecord) {
            return Response::error(config('notification.error_code.notification_notfound', 1000), 'Notification not found.');
        }

        $notification->is_read = 1;
        $notification->save();

        return Response::success([
            'notification' => new $this->notificationUserResource($notification)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function readAll(Request $request)
    {
        $user = $request->user();

        $notification = NotificationRecord::query()
            ->where('user_id', $user->id)
            ->update([
                'is_read' => 1
            ]);

        return Response::success();
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        $notification = NotificationRecord::query()
            ->where('id', $id)
            ->where('user_id', $user->id)
            //->where('status', \Boykioyb\Notify\Services\Common\Notify::STATUS_SUCCESS)
            ->first();

        if (!$notification instanceof NotificationRecord) {
            return Response::error(config('notification.error_code.notification_notfound', 1000), 'Notification not found.');
        }

        $notification->delete();

        return Response::success();
    }
}
