<?php

namespace Boykioyb\Notify\Models;


use Illuminate\Database\Eloquent\Model;


/**
 * Class NotificationRecord
 * @package Boykioyb\Notify\Models
 */
class NotificationRecord extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'notification_id',
        'device_id',
        'user_id',
        'status',
        'is_read',
        'meta_data',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function device()
    {
        return $this->hasOne(NotificationDevice::class, 'id', 'device_id');
    }
}
