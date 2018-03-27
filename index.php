<?php

require 'core/bootstrap.php';

require_once 'app/Models/Generic.php';
require_once 'app/Models/ComboBoxElement.php';


require_once 'app/Models/Person.php';
require_once 'app/Models/Consert.php';
require_once 'app/Controllers/ConsertController.php';

require_once 'app/Models/Discount.php';

require_once 'app/Models/Status.php';

require_once 'app/Controllers/DiscountController.php';

require_once 'app/Models/Order.php';
require_once 'app/Controllers/OrderController.php';

require 'routes.php';

$uri = $_GET['uri'] ?? '';

require $router->parse($uri);