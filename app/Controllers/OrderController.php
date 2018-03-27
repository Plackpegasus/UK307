<?php

$orders = [];

function getAllOrders($querstring)
{
    return getAllData($querstring);
}

function createAllOrders($querstring)
{
    global $orders;

    $orders = [];
    $data = getAllOrders($querstring);

    for ($index = 0; $index < count($data); $index++)
    {
        $order = createOrder(null, $data["{$index}"]["name"], $data["{$index}"]["email"], $data["{$index}"]["phonenumber"],
            $data["{$index}"]["fk_id_concert"], null,
            $data["{$index}"]["fk_id_discount"], null, null, null,
            $data["{$index}"]["fk_id_status"], null,  $data["{$index}"]["id"]
        );
        array_push($orders, $order);
    }
}

function getOrders()
{
    global $orders;
    return $orders;
}

function createOrder($person_id = null, $person_name = null, $person_email = null, $person_phonenumber = null,
                     $consert_id = null, $consert_text = null,
                     $discount_id = null, $discount_disount = null, $discount_deadline = null, $discount_text = null,
                     $status_id = 1, $status_text = null,
                     $order_id = null)
{
    $person = new Person($person_id, $person_name, $person_email, $person_phonenumber);
    $consert = new Concert($consert_id, $consert_text);
    $discount = new Discount($discount_id, $discount_disount, $discount_deadline, $discount_text);
    $status = new  Status($status_id, $status_text);
    return new Order($order_id, $person, $consert, $discount, $status);
}