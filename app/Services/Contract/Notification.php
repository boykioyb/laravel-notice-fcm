<?php

namespace Boykioyb\Notify\Services\Contract;


/**
 * Interface Notification
 * @package Boykioyb\Notify\Services\Contract
 */
interface Notification
{

    /**
     * @param $to
     * @param $data
     * @param array $options
     * @return mixed
     */
    public function send($to, $data, array $options = []);
}
