<?php

print_r($_POST);
$o = new Order($_POST["user-email"], $_POST["user-email"], $_POST["user-phonenumber"], $_POST["conzertds"], $_POST["procends"], FALSE);
//$o->createOrder();
echo "OK";
