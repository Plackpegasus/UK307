<?php
/**
 * Created by PhpStorm.
 * User: h3e
 * Date: 26.03.2018
 * Time: 20:04
 */

const SELECTS_DISCOUNT = ["DROPDOWN" => ["GETTEXT" => "SELECT t.id, t.text as text from konsert_tickets.discount_tab t ORDER BY t.id"]];

class Discount
{
    private $id;
    private $discount;
    private $deadline;
    private $text;

    function __construct($id = null, $discount = null, $deadline = null, $text=null)
    {
        $this->id = $id;
        $this->discount = $discount;
        $this->discount = $deadline;
        $this->discount = $text;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function getDeadline()
    {
        return $this->deadline;
    }

    public function getText()
    {
        return $this->text;
    }
}