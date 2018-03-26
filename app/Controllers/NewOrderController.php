<?php
header('NEW');

$o = new Order($_POST["user-name"], $_POST["user-email"], $_POST["user-phonenumber"], $_POST["conzertds"], $_POST["procends"], 1);
$res = $o->createOrder();

if($res === 0)
{
    echo "Error";
}

header("Location: /UK307/Projektarbeit/NEW");