<?php

namespace Boykioyb\Notify\Services;


use App\Services\Log\Log;
use Boykioyb\Notify\Services\Contract\Notification;


/**
 * Class Firebase
 * @package Boykioyb\Notify\Services
 */
class Firebase implements Notification
{

    /**
     * @param $to
     * @param $data
     * @param array $options
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function send($to, $data, array $options = [])
    {
        $log = \Illuminate\Support\Facades\Log::channel('notification');

        $url = config('notification.fcm.api_url') . "/fcm/send";

        $headers = [
            "Authorization: key=" . config('notification.fcm.api_key'),
            "Content-Type: application/json"
        ];
        
        if (isset($data['notification']['id'])) {
            $data['content'] = $data['notification']['id'];
        }

        $params = [
            'priority' => 'HIGH',
            //'data' => $data,
            'data' => $data['notification'],
            'notification' => $data['notification'],
            'to' => $to
        ];
        
        $log->info($to, [
            'Url' => $url,
            'Headers' => $headers,
            'Params' => $params
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => $headers
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $log->info($to, [
            'Response' => $response,
        ]);

        if ($err) {
            return [
                'error' => $err
            ];
        }

        return [
            'data' => $response
        ];
    }

}
