<?php

const SELECTS_CONSERTS = ["CONSTRUCTOR" => ["ALL" => "SELECT t.id, t.name from konsert_tickets.concert_tab t ORDER BY t.name"],
    "GET" => ["CONSERTBYID" => "SELECT t.name from konsert_tickets.concert_tab t WHERE t.id = :id"],
                            ];

class Concert extends ComboBoxElement
{
    private $id;
    private $concert;

    function __construct($id = null, $concert = null)
    {
        $this->id = $id;
        $this->concert = $concert;
    }

    public function setConcertById()
    {
        $data = getFirstColumn(str_replace(":id", $this->id, SELECTS_CONSERTS["GET"]["CONSERTBYID"]));
        $this->concert = $data;
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