<?php declare(strict_types=1);

namespace App\Core;

use Exception;

class App
{
    protected static array $container = [];

    /**
     * @return void
     */
    public static function bind($key, $value)
    {
        static::$container[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws Exception
     */
    public static function get(string $key): mixed
    {
        if (!array_key_exists($key, static::$container)) {
            throw new Exception("No {$key} in the App container");
        }

        return static::$container[$key];
    }
}