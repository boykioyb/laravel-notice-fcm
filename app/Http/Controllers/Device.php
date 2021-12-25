<?php

namespace Boykioyb\Notify\Http\Controllers;


use Boykioyb\Notify\Http\Requests\StoreDeviceRequest;
use Boykioyb\Notify\Models\NotificationDevice;
use Boykioyb\Notify\Services\Common\Response;


/**
 * Class Device
 * @package Boykioyb\Notify\Http\Controllers
 */
class Device extends Base
{


    /**
     * @param StoreDeviceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDeviceRequest $request)
    {
        $user = $request->user();

        if (empty($user)) {
            return response()->json([
                'success' => false,
                'error' => [
                    'message' => 'User not login.'
                ]
            ]);
        }

        $device = NotificationDevice::query()
            ->where('user_id', $user->id)
            ->where('token', $request->token)
            ->first();
        if (!$device instanceof NotificationDevice) {
            NotificationDevice::query()
                ->where('user_id', $user->id)
                ->orWhere('token', $request->token)
                ->delete();

            $platform = strtolower($request->header('Platform'));
            NotificationDevice::query()->create([
                'user_id' => $user->id,
                'token' => $request->token,
                'platform' => $platform,
            ]);
        }

        return Response::success();
    }

}
