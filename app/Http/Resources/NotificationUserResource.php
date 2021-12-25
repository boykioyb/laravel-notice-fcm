<?php

namespace Boykioyb\Notify\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Boykioyb\Notify\Services\Common\HashID;


/**
 * Class NotificationUserResource
 * @package Boykioyb\Notify\Http\Resources
 */
class NotificationUserResource extends JsonResource
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
            'title' => !empty($this->notification) ? $this->notification->title : '',
            'description' => !empty($this->notification) ? $this->notification->description : '',
            'action' => !empty($this->notification) ? $this->notification->action : '',
            'content' => !empty($this->notification) ? $this->notification->content : '',
            //'notification' => !empty($this->notification) ? $this->notification : null,
            'is_read' => !empty($this->is_read) ? $this->is_read : 0,
            'created_at' => !empty($this->created_at) ? $this->created_at : '',
            'updated_at' => !empty($this->updated_at) ? $this->updated_at : ''
        ];
    }
}
