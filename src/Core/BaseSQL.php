<?php
declare(strict_types=1);

namespace Core;

use Models\PdoInterface;

class BaseSQL implements PdoInterface
{
    protected $pdo;

    public function __construct(string $dbdriver, string $dbhost, string $dbname, string $dbuser, string $dbpwd)
    {
        try {
            $this->pdo = new \PDO($dbdriver . ':host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpwd);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            die('Erreur SQL : ' . $e->getMessage());
        }
    }

    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}
