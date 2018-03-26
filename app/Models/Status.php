<?php
/**
 * Created by PhpStorm.
 * User: h3e
 * Date: 26.03.2018
 * Time: 20:10
 */

class Status
{
    private $id;
    private $status;

    function __construct($id, $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }
}