<?php


namespace Boykioyb\Notify\Services\Common;


use Hashids\Hashids;


/**
 * Class HashID
 * @package Boykioyb\Notify\Services\Common
 */
class HashID
{

    /**
     * @param $integer
     * @param int $length
     * @return string
     */
    public static function idEncode($integer, $length = 8)
    {
        $hashids = new Hashids(config('notification.hash_id.salt'), $length, config('hashing.hash_id.alphabet'));

        return $hashids->encode($integer);
    }


    /**
     * @param $string
     * @param int $length
     * @return int
     */
    public static function idDecode($string, $length = 8)
    {
        $hashids = new Hashids(config('notification.hash_id.salt'), $length, config('hashing.hash_id.alphabet'));

        $ids = $hashids->decode($string);

        if (!empty($ids))
            return $ids[0];

        return 0;
    }
}
