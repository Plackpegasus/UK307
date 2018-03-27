<?php

$data = $_POST;

if(!empty($data))
{
    foreach ($data as $key => $value)
    {
        Order::changeStatusIdByOrderId($value, 2);
    }
}
header("Location: VIEW");

