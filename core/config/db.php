<?php

namespace App\Core\Config;
use PDO;

class Connection
{
    /**
     * @throws Exception
     */
    public static function connect($config)
    {
        try {
            return new PDO(
                $config['host'] . ';dbname=' . $config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

}
