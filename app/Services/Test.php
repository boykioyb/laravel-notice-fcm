<?php

namespace Boykioyb\Notify\Services;


use Illuminate\Support\Facades\Log;
use Boykioyb\Notify\Services\Contract\Notification;

/**
 * Class Test
 * @package Boykioyb\Notify\Services
 */
class Test implements Notification
{
    /**
     * @param $to
     * @param $data
     * @param array $options
     * @return mixed|void
     */
    public function send($to, $data, array $options = [])
    {
        $log = Log::channel('notification');

        $log->info('Test notification...!');
    }

}
