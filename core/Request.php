<?php declare(strict_types=1);

namespace App\Core;

class Request {
    /**
     * @return string
     */
    public static function uri(): string
    {
        return trim(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH),'/');
    }

    /**
     * @return string
     */
    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}