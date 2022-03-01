<?php

namespace App\Core\Database;
use PDO;

class QueryBuilder
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectAll($table, $userID = 1, $order = 'ASC')
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . $table . ' WHERE user_id = ' . $userID. ' ORDER BY id ' . $order);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert($table, $data)
    {
        $keys = array_keys($data);

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            implode(',', $keys),
            ':' . implode(', :', $keys)
        );

        try {
            $statement = $this->pdo->prepare($sql);

            return $statement->execute($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function get($sql)
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_OBJ);
    }
}