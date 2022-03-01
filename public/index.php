<?php

require "../vendor/autoload.php";
require '../core/bootstrap.php';

use App\Core\Router;
use App\Core\Request;


$router = new Router();

require '../app/routes.php';

try {
    $router->direct(Request::uri(), Request::method());
} catch (Exception $e) {
    echo $e->getMessage();
}
