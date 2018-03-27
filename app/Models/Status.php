<?php
/**
 * Created by PhpStorm.
 * User: h3e
 * Date: 26.03.2018
 * Time: 20:10
 */

const SELECTS_STATUS = ["GET" => ["STATUSTBYID" => "SELECT t.status from konsert_tickets.status_tab t WHERE t.id = :id"],
    "INSERT" => ["CHANGESTATUSIDBYORDERID"=> "update konsert_tickets.tickets_tab set fk_id_status = :fk WHERE id = :id"]
    ];

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

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setStatusById()
    {
        $data = getFirstColumn(str_replace(":id", $this->id, SELECTS_STATUS["GET"]["STATUSTBYID"]));
        $this->status = $data;
    }

    public function getStatus()
    {
        return $this->status;
    }
}