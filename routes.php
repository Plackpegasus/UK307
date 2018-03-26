<?php

$router = new Router();

$router->define([
    '' => 'app/Controllers/WelcomeController.php',
    'NEW' => 'app/Controllers/NewController.php',
    'EDIT' => 'app/Controllers/EditController.php',
    'ORDER' => 'app/Controllers/OrderController.php'
]);