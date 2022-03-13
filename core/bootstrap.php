<?php

use App\Core\App;
use App\Core\Database\QueryBuilder;
use App\Core\Config\Connection;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

App::bind('config', require '../config.php');

try {
    App::bind('database', new QueryBuilder(
        Connection::connect(App::get('config')['database'])
    ));
} catch (Exception $e) {
    echo $e->getMessage();
}

/**
 * @param $path
 * @param $data
 * @return mixed
 */
function view($path, $data = []): mixed
{
    extract($data);

    return require "../app/views/{$path}.view.php";
}

/**
 * @param $data
 * @param int $status
 * @return void
 */
function response($data, int $status = 200)
{
    http_response_code($status);
    echo json_encode($data);
}
/**
 * @param $path
 * @return void
 */
function redirect($path)
{
    header("Location: /{$path}");
    die;
}

/**
 * @return false|mixed
 */
function authCheck(): mixed
{
    if (isset($_SESSION['user'])) {
        return $_SESSION['user'];
    }

    return false;
}


function old($value)
{
    if (isset($_SESSION['old_values'][$value])) {
        $old = $_SESSION['old_values'][$value];
        unset($_SESSION['old_values'][$value]);

        return $old;
    }

    return '';
}

/**
 * @param $value
 * @return void
 */
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die;
}