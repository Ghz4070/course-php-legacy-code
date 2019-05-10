<?php
declare(strict_types=1);

namespace Repository;

use Entity\Users;

class UsersRepository
{
    private $pdo;
    private $table;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->table = get_called_class();
    }

    public function getOneBy(array $where, bool $object = false): ?array
    {
        $sqlWhere = [];
        foreach ($where as $key => $value) {
            $sqlWhere[] = $key . '=:' . $key;
        }
        $sql = ' SELECT * FROM ' . $this->table . ' WHERE  ' . implode(' AND ', $sqlWhere) . ';';
        $query = $this->pdo->prepare($sql);

        if ($object) {
            $query->setFetchMode(\PDO::FETCH_INTO, $this);
        } else {
            $query->setFetchMode(\PDO::FETCH_ASSOC);
        }

        try {
            $query->execute($where);
            return $query->fetch();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    public function save(Users $user): void
    {
        $dataObject = get_object_vars($user);
        $dataObjectIdentity = get_object_vars($dataObject['identity']);
        $dataObjectUser = array_splice($dataObject, 0, 5);
        $data = array_merge($dataObjectUser, $dataObjectIdentity);
        $dataChild = array_diff_key($dataObject, get_class_vars(get_class()));

        if (is_null($data['id'])) {
            $sql = 'INSERT INTO Users' . ' ( ' .
                implode(',', array_keys($data)) . ') VALUES ( :' .
                implode(',:', array_keys($data)) . ')';

            $query = $this->pdo->prepare($sql);
            $query->execute($data);
        } else {
            $sqlUpdate = [];
            foreach ($data as $key => $value) {
                if ('id' != $key) {
                    $sqlUpdate[] = $key . '=:' . $key;
                }
            }

            $sql = 'UPDATE ' . $this->table . ' SET ' . implode(',', $sqlUpdate) . ' WHERE id=:id';

            $query = $this->pdo->prepare($sql);
            $query->execute($dataChild);
        }
    }

    public function getUserLogin(string $login): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE email = :login");
        $stmt->bindParam('login', $login);
        $stmt->execute();
        return $stmt->fetch();
    }

}