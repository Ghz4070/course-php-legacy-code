<?php
declare(strict_types=1);

namespace Core;

use Models\PdoInterface;
use PDO;
use Exception;

class BaseSQL implements PdoInterface
{
    private $pdo;

    public function __construct(string $dbDriver, string $dbHost, string $dbName, string $dbUser, string $dbPassword)
    {
        try {
            $this->pdo = new PDO($dbDriver . ':host=' . $dbHost . ';dbName=' . $dbName, $dbUser, $dbPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur SQL : ' . $e->getMessage());
        }
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}