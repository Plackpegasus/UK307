<?php

$router = new Router();

$router->define([
    '' => 'app/Controllers/DashboardController.php',
    'NEW' => 'app/Controllers/NewOrderController.php',
    'ORDER' => 'app/Controllers/CreateOrderController.php',
    'VIEW' => 'app/Controllers/ViewController.php',
    'CHANGE' => 'app/Controllers/ChangeController.php',
    'EDIT' => 'app/Controllers/EditController.php'
]);