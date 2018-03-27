<?php

$order = createOrder(null, $_POST["user-name"], $_POST["user-email"], $_POST["user-phonenumber"], $_POST["conserts"], null, $_POST["discount"], null, null, null, 1, null, null);
$order->createOrder();
header("Location: NEW");

