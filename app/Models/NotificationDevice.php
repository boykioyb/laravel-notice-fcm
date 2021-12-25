<?php

namespace Boykioyb\Notify\Models;


use Illuminate\Database\Eloquent\Model;


/**
 * Class NotificationDevice
 * @package Boykioyb\Notify\Models
 */
class NotificationDevice extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
        'platform',
    ];

}
