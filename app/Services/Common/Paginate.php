<?php
namespace Boykioyb\Notify\Services\Common;


use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class Paginate
 * @package Boykioyb\Notify\Services\Common
 */
class Paginate
{

    /**
     * @param LengthAwarePaginator $data
     * @return array
     */
    public static function getMetaData(LengthAwarePaginator $data)
    {
        return [
            'current_page' => $data->currentPage(),
            'from' => $data->firstItem(),
            'last_page' => $data->lastPage(),
            'next_page_url' => $data->nextPageUrl(),
            'per_page' => $data->perPage(),
            'prev_page_url' => $data->previousPageUrl(),
            'to' => $data->lastItem(),
            'total' => $data->total(),
        ];
    }
}
