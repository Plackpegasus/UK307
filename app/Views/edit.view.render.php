<?php

const ROWEDITTEMPLATE   = "<tr>?rows</tr>";
const FIELDEDITTEMPLATE = "<td>?value</td>";

function renderEditTable()
{
    $orders = getOrders();

    if(!empty($orders))
    {
        $dates = $orders[0]->getDiscount()->getTimeToBuy();

        $html = "";
        for ($index = 0; $index < count($orders); $index++)
        {
            $row = renderEditRow($orders[$index], $dates[$index]["ENDDATE"]);
            $html .= $row;
        }
        return $html;
    }

    return $orders;
}

function renderEditorError()
{
    return "<h1>Error</h1>";
}

function renderEditRow($order, $timedate)
{
    $order->getConsert()->setConcertById();
    $order->getStatus()->setStatusById();

    //Order
    $row = renderEditField($order->getId());

    //Person
    $row .= renderEditField($order->getPerson()->getName());
    $row .= renderEditField($order->getPerson()->getEmail());
    $row .= renderEditField($order->getPerson()->getPhonenumber());

    //Consert
    $row .= renderEditField($order->getConsert()->getConcert());

    //Status
    $row .= renderEditField($order->getStatus()->getStatus());

    //Time
    $row .=  renderEditField($timedate);

    //Button for edit
    $row .= renderEditField("<input type=\"checkbox\" name=\"" . $order->getId() . "\" value=\"" . $order->getId() . "\">");

    $row =  str_replace("?rows", $row, ROWEDITTEMPLATE);

    return $row;
}

function renderEditField($value)
{
    $field = str_replace("?value", $value, FIELDEDITTEMPLATE);
    return $field;
}
