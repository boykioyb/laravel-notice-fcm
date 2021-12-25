<?php

namespace Boykioyb\Notify\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Boykioyb\Notify\Services\Common\HashID;

/**
 * Class NotificationResource
 * @package Boykioyb\Notify\Http\Resources
 */
class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => HashID::idEncode($this->id),
            'title' => !empty($this->title) ? $this->title : '',
            'description' => !empty($this->description) ? $this->description : '',
            'receiver_type' => !empty($this->receiver_type) ? $this->receiver_type : '',
            'receiver_id' => !empty($this->receiver_id) ? HashID::idEncode($this->receiver_id) : null,
            'status' => !empty($this->status) ? $this->status : '',
            'action' => !empty($this->action) ? $this->action : '',
            'content' => !empty($this->content) ? $this->content : null,
            'send_data' => !empty($this->send_data) ? $this->send_data : null,
            'creator_type' => !empty($this->creator_type) ? $this->creator_type : '',
            'creator_id' => !empty($this->creator_id) ? HashID::idEncode($this->creator_id) : null,
            'moderator_id' => !empty($this->moderator_id) ? HashID::idEncode($this->moderator_id) : null,
            'created_at' => !empty($this->created_at) ? $this->created_at : '',
            'updated_at' => !empty($this->updated_at) ? $this->updated_at : ''
        ];
    }
}
