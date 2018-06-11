<?php

namespace App;


class Challenge implements \JsonSerializable
{
    public $id;

    public $title;

    public $introduction;

    public $points;

    public function __construct($id, $title, $introduction, $points)
    {
        $this->id           = $id;
        $this->title        = $title;
        $this->introduction = $introduction;
        $this->points       = $points;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return $this;
    }
}