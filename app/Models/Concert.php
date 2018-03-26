<?php

const SELECTS_CONCERT = ["DROPDOWN" => ["GETNAME" => "SELECT t.id, t.name as text from konsert_tickets.concert_tab t ORDER BY t.name"]];

class Concert
{
    private $id;
    private $concert;

    function __construct($id = null, $concert = null)
    {
        $this->id = $id;
        $this->concert = $concert;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getConcert()
    {
        return $this->concert;
    }
}