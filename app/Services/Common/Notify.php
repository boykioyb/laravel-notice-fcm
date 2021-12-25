<?php

namespace Boykioyb\Notify\Services\Common;

use Illuminate\Support\Facades\Route;
use Boykioyb\Notify\Http\Resources\NotificationDeviceResource;
use Boykioyb\Notify\Http\Resources\NotificationRecordResource;
use Boykioyb\Notify\Http\Resources\NotificationResource;
use Boykioyb\Notify\Http\Resources\NotificationUserResource;
use Boykioyb\Notify\Services\Contract\Notification;
use Boykioyb\Notify\Services\Firebase;
use Boykioyb\Notify\Services\Test;

/**
 * Class Notify
 */
class Notify
{

    const PROVIDER_FIREBASE = 'firebase';

    const STATUS_PENDING = 'PENDING';
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_PROCESSING = 'PROCESSING';
    const STATUS_SUCCESS = 'SUCCESS';

    const STATUS_RECORD_PENDING = 'PENDING';
    const STATUS_RECORD_PROCESSING = 'PROCESSING';
    const STATUS_RECORD_SUCCESS = 'SUCCESS';
    const STATUS_RECORD_FAIL = 'FAIL';
    const STATUS_RECORD_DEVICE_NOT_EXISTS = 'DEVICE_NOT_EXISTS';
    const STATUS_RECORD_NOTIFICATION_NOT_FOUND = 'NOTIFICATION_NOT_FOUND';

    const CREATOR_TYPE_USER = 'USER';
    const CREATOR_TYPE_ADMIN = 'ADMIN';

    const RECEIVER_TYPE_ALL = 'ALL';
    const RECEIVER_TYPE_USER = 'USER';
    const RECEIVER_TYPE_GROUP = 'GROUP';

    /**
     * @return array
     */
    public static function singletons()
    {
        $provider = config('notification.default');

        if ($provider == static::PROVIDER_FIREBASE) {
            return [
                Notification::class => Firebase::class
            ];
        }

        return [
            Notification::class => Test::class
        ];
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function getNotificationResource()
    {
        return config('notification.aliases.notification_resource', NotificationResource::class);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function getNotificationInfo()
    {
        return config('notification.aliases.notification_info', \Boykioyb\Notify\Services\Notification::class);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function getNotificationRecordResource()
    {
        return config('notification.aliases.notification_record_resource', NotificationRecordResource::class);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function getNotificationDeviceResource()
    {
        return config('notification.aliases.notification_device_resource', NotificationDeviceResource::class);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function getNotificationUserResource()
    {
        return config('notification.aliases.notification_user_resource', NotificationUserResource::class);
    }

    /**
     *
     */
    public static function routes()
    {
        $defaultOptions = [
            'prefix' => 'notify',
            'middleware' => ['auth:api'],
            'admin_prefix' => 'admin/notify',
            'admin_middleware' => ['auth:api']
        ];

        $options = array_merge($defaultOptions, config('notification.route', []));

        Route::group(['prefix' => $options['prefix']], function () use ($options) {
            Route::get('health', 'Test@index');

            Route::group(['middleware' => $options['middleware']], function () {
                Route::post('device', 'Device@store');

                Route::get('', 'Notify@index');
                Route::post('{nid}/read', 'Notify@read');
                Route::get('{nid}', 'Notify@show');
                Route::post('read-all', 'Notify@readAll');
                Route::delete('{nid}', 'Notify@destroy');
            });
        });

        Route::group(['prefix' => $options['admin_prefix']], function () use ($options) {
            Route::group(['middleware' => $options['admin_middleware']], function () {
                Route::get('', 'Admin\Notify@index');
                Route::get('devices', 'Admin\Notify@devices');
                Route::get('{nid}', 'Admin\Notify@show');
                Route::post('', 'Admin\Notify@store');
                Route::post('{nid}', 'Admin\Notify@update');
                Route::get('{nid}/records', 'Admin\Notify@records');
                Route::post('{nid}/approve', 'Admin\Notify@approve');
                Route::delete('{nid}', 'Admin\Notify@destroy');
            });
        });
    }
}
