<?php

namespace Boykioyb\Notify\Events;


use App\Events\Event;


/**
 * Class CreateNotify
 * @package Boykioyb\Notify\Events
 */
class CreateNotify extends Event
{

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $options = [];


    /**
     * SendNotify constructor.
     * @param array $data
     * @param array $options
     */
    public function __construct($data = [], $options = [])
    {
        $this->data = $data;
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }


}
