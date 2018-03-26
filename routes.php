<?php

$router = new Router();

$router->define([
    '' => 'app/Controllers/WelcomeController.php',
    'NEW' => 'app/Controllers/NewController.php',
    'NEWORDER' => 'app/Controllers/OrderController.php'
]);