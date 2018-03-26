<?php

require 'core/bootstrap.php';
require 'app/Models/Order.php';

require 'routes.php';
$uri = $_GET['uri'] ?? '';

require $router->parse($uri);