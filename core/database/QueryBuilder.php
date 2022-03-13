<?php declare(strict_types=1);

namespace App\Core\Database;

use Exception;
use PDO;

class QueryBuilder
{
    private PDO $pdo;
    private $statement;
    private array $tables = [
        'users',
        'words'
    ];
    private array $orders = [
        'asc',
        'desc'
    ];

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $table
     * @param int $userID
     * @param string $order
     * @return bool|array
     * @throws Exception
     */
    public function selectAll(string $table, int $userID = 1, string $order = 'ASC'): bool|array
    {
        if (!in_array($table, $this->tables)) {
            throw new Exception('Table name is not valid');
        }

        if (!in_array(strtolower($order), $this->orders)) {
            throw new Exception('Order param is not valid');
        }

        $statement = $this->pdo->prepare(
            'SELECT * FROM ' . $table .
            ' WHERE user_id = :userID 
            ORDER BY id ' . $order
        );

        $statement->bindParam('userID', $userID, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param string $table
     * @param array $data
     * @return bool|string
     */
    public function insert(string $table, array $data): bool|string
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

    /**
     * @param array $sql
     * @return mixed
     */
    public function get(array $sql): mixed
    {
        $this->statement = $this->pdo->prepare($sql['sql']);

        if (isset($sql['params'])) {
            $this->renderParameters($sql);
        }

        $this->statement->execute();

        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    private function renderParameters($sql)
    {
        foreach ($sql['params'] as $key => &$param) {
            $this->statement->bindParam($key, $param);
        }
    }
}