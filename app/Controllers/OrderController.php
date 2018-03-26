<?php

$o = new Order("",  $_POST["user-name"], $_POST["user-email"],  $_POST["user-phonenumber"], $_POST["conzertds"], $_POST["procends"], 1);
$o->createOrder();

header("Location: NEW");
