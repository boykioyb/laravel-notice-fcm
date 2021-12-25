<?php

namespace Boykioyb\Notify\Services\Common;


use Illuminate\Http\JsonResponse;

/**
 * Class Response
 * @package Boykioyb\Notify\Services\Common
 */
class Response
{
    /**
     * @param array $data
     * @param string|null $message
     * @param array $extraData
     * @return JsonResponse
     */
    public static function success(array $data = [], string $message = null, array $extraData = [])
    {
        $responseData = [
            'success' => true,
            'message' => !empty($message) ? $message : '',
            'data' => !empty($data) ? $data : new \stdClass()
        ];

        $responseData = array_merge($responseData, $extraData);

        return response()->json($responseData);
    }

    /**
     * @param int $errorCode
     * @param string|null $message
     * @param array $errors
     * @param array $extraData
     * @param int $httpStatusCode
     * @return JsonResponse
     */
    public static function error(int $errorCode = 1000, string $message = null, array $errors = [], array $extraData = [], int $httpStatusCode = 200)
    {
        $responseData = [
            'success' => false,
            'error' => [
                'code' => $errorCode,
                'message' => !empty($message) ? $message : '',
                'errors' => $errors
            ]
        ];

        $responseData = array_merge($responseData, $extraData);

        return response()->json($responseData, $httpStatusCode);
    }
}
