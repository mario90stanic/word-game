<?php

require "../vendor/autoload.php";
require '../core/bootstrap.php';

use App\Container\Container;
use App\Core\Router;
use App\Core\Request;

$container = new Container();
$router = new Router($container);

require '../app/routes.php';

try {
    $router->direct(Request::uri(), Request::method());
} catch (Exception $e) {
    echo $e->getMessage();
}
