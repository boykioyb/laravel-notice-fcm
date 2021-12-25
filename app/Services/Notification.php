<?php


namespace Boykioyb\Notify\Services;


/**
 * Class Notification
 * @package Boykioyb\Notify\Services
 */
class Notification
{
    /**
     * @var
     */
    private $title;
    /**
     * @var
     */
    private $description;
    /**
     * @var
     */
    private $action;


    /**
     * @var array|null
     */
    private $content = [];


    /**
     * @var array|null
     */
    private $extraData = [];

    /**
     * Notification constructor.
     * @param $title
     * @param $description
     * @param $action
     * @param null $content
     * @param null $extraData
     */
    public function __construct($title, $description, $action, $content = [], $extraData = [])
    {
        $this->title = $title;
        $this->description = $description;
        $this->action = $action;
        $this->content = $content;
        $this->extraData = $extraData;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return null
     */
    public function getContent()
    {
        return !empty($this->content) ? $this->content : [];
    }

    /**
     * @param null $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return null
     */
    public function getExtraData()
    {
        return !empty($this->extraData) ? $this->extraData : [];
    }

    /**
     * @param null $extraData
     */
    public function setExtraData($extraData)
    {
        $this->extraData = $extraData;
    }

    /**
     * @return array
     */
    public function getSendData()
    {
        $content = $this->getContent();

        $sendData = [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'action' => $this->getAction(),
            'data' => !empty($content) ? $content : null
        ];

        return array_merge($sendData, $this->getExtraData());
    }
}
