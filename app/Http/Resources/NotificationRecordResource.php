<?php

namespace Boykioyb\Notify\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Boykioyb\Notify\Services\Common\HashID;

/**
 * Class NotificationRecordResource
 * @package Boykioyb\Notify\Http\Resources
 */
class NotificationRecordResource extends JsonResource
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => HashID::idEncode($this->id),
            'notification_id' => !empty($this->notification_id) ? HashID::idEncode($this->notification_id) : null,
            'device_id' => !empty($this->device_id) ? HashID::idEncode($this->device_id) : null,
            'device' => !empty($this->device) ? $this->device : null,
            'status' => !empty($this->status) ? $this->status : '',
            'is_read' => !empty($this->is_read) ? $this->is_read : 0,
            'created_at' => !empty($this->created_at) ? $this->created_at : '',
            'updated_at' => !empty($this->updated_at) ? $this->updated_at : ''
        ];
    }
}
