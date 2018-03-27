<?php

const ROWTEMPLATE   = "<tr>?rows</tr>";
const FIELDTEMPLATE = "<td>?value</td>";

function renderViewTable()
{
    $orders = getOrders();

    if(!empty($orders))
    {
        $dates = $orders[0]->getDiscount()->getTimeToBuy();

        $html = "";
        for ($index = 0; $index < count($orders); $index++)
        {
            $row = renderViewRow($orders[$index], $dates[$index]["TIMEDIFF"],  $dates[$index]["ENDDATE"]);
            $html .= $row;
        }
        return $html;
    }

    return renderViewError();
}

function renderViewError()
{
    return "<h1>Error</h1>";
}

function renderViewRow($order, $timediff, $timedate)
{
    $order->getConsert()->setConcertById();

    //Person
    $row = renderViewField($order->getPerson()->getName());
    $row .= renderViewField($order->getPerson()->getEmail());

    $row .=  renderViewField($order->getConsert()->getConcert());

    //Time
    $row .=  renderViewField($timedate);
    $row .=  renderViewField((0 <= $timediff) ? '⌛' : '<img class="emoji" alt="hourglass_flowing_sand" src="https://assets-cdn.github.com/images/icons/emoji/unicode/23f3.png" width="20" height="20">');

    //Button
    $row .= renderViewField("<input type=\"checkbox\" name=\"check". $order->getId() . "\" value=\"". $order->getId() . "\">");

    $row =  str_replace("?rows", $row, ROWTEMPLATE);

    return $row;
}

function renderViewField($value)
{
    $field = str_replace("?value", $value, FIELDTEMPLATE);
    return $field;
}

