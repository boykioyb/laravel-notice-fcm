<?php

namespace Boykioyb\Notify\Models;


use Illuminate\Database\Eloquent\Model;


/**
 * Class Notification
 * @package Boykioyb\Notify\Models
 */
class Notification extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'receiver_type',
        'receiver_id',
        'status',
        'action',
        'content',
        'send_data',
        'creator_type',
        'creator_id',
        'moderator_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function receiver()
    {
        return $this->belongsTo(config('notification.aliases.user_model'), 'receiver_id');
    }
}
