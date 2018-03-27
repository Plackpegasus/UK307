<?php
/**
 * Created by PhpStorm.
 * User: h3e
 * Date: 26.03.2018
 * Time: 20:04
 */

const SELECTS_DISCOUNT = ["CONSTRUCTOR" => ["ALL" => "SELECT * from konsert_tickets.discount_tab t ORDER BY t.id"],
                         "VIEW" => ["GETINFO" => "
    SELECT
    DATEDIFF(
        DATE_ADD(
            tt.buy_date,
            INTERVAL dt.deadline DAY
        ),
        NOW()) AS TIMEDIFF,
        DATE(
            DATE_ADD(
                tt.buy_date,
                INTERVAL dt.deadline DAY
            )
        ) AS ENDDATE
    FROM
        tickets_tab tt
    LEFT JOIN discount_tab dt ON
        tt.fk_id_discount = dt.id
    ORDER BY
        tt.buy_date
"]];

class Discount extends ComboBoxElement
{
    private $id;
    private $discount;
    private $deadline;
    private $text;

    function __construct($id = null, $discount = null, $deadline = null, $text=null)
    {
        $this->id = $id;
        $this->discount = $discount;
        $this->deadline = $deadline;
        $this->text = $text;
    }

    public function getTimeToBuy()
    {
        $data = getAllData(str_replace(":id", $this->id, SELECTS_DISCOUNT["VIEW"]["GETINFO"]));
        return $data;
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