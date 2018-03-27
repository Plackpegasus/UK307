<?php

$discounts = [];

createAllDiscounts();

function getAllDiscounts()
{
    return getAllData(SELECTS_DISCOUNT["CONSTRUCTOR"]["ALL"]);
}

function createAllDiscounts()
{
    global $discounts;

    $discounts = [];
    $data = getAllDiscounts();

    for ($index = 0; $index < count($data); $index++)
    {
        $discount = new Discount($data["{$index}"]["id"], $data["{$index}"]["discount"], $data["{$index}"]["deadline"], $data["{$index}"]["text"]);
        array_push($discounts, $discount);
    }
}

function renderDiscountComboxBoxElements()
{
    global $discounts;
    $html = "";

    for ($index = 0; $index < count($discounts); $index++)
    {
        $discount = $discounts[$index];
        $html .=  $discount->renderComboBoxTemplate($discount->getId(), $discount->getText());
    }

    return $html;
}