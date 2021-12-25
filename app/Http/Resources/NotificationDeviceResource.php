<?php

namespace Boykioyb\Notify\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Boykioyb\Notify\Services\Common\HashID;


/**
 * Class NotificationDeviceResource
 * @package Boykioyb\Notify\Http\Resources
 */
class NotificationDeviceResource extends JsonResource
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => HashID::idEncode($this->id),
            'user_id' => !empty($this->user_id) ? HashID::idEncode($this->user_id) : null,
            'token' => !empty($this->token) ? $this->token : '',
            'platform' => !empty($this->platform) ? $this->platform : '',
            'created_at' => !empty($this->created_at) ? $this->created_at : '',
            'updated_at' => !empty($this->updated_at) ? $this->updated_at : ''
        ];
    }
}
