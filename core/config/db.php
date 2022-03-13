<?php declare(strict_types=1);

namespace App\Core\Config;

use Exception;
use PDO;
use PDOException;

class Connection
{
    /**
     * @throws Exception
     */
    public static function connect($config): PDO
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
