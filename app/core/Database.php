<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use App\Core\Request;

class Database {
    private $connection;
    private $statement;

    function __construct(array $config) {
        try {
            $dsn = 'mysql:dbname=' . $config['dbname'] . ';host=' . $config['host'] . ';port=' . $config['port'] . ';charset=' . $config['charset'];

            $this->connection = new PDO($dsn, $config['user'], $config['pass'], [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function query(string $query, array $params = []) {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);

        return $this;
    }

    public function fetchAll() {
        return $this->statement->fetchAll();
    }

    public function fetch() {
        return $this->statement->fetch();
    }

    public function findOrFail() {
        $result = $this->fetch();

        if (!$result) {
            Request::abort(404);
        }

        return $result;
    }
}
