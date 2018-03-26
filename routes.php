<?php

$router = new Router();

$router->define([
    '' => 'app/Controllers/WelcomeController.php',
    'NEW' => 'app/Controllers/NewViewController.php',
    'NEWORDER' => 'app/Controllers/OrderController.php',
    'EDIT' => 'app/Controllers/EditController.php',
    'ORDER' => 'app/Controllers/OrderController.php'
]);