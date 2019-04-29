<?php
declare(strict_types=1);

namespace core;

class BaseSQL
{
    private $pdo;
    private $table;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(DBDRIVER.":host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPWD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die("Erreur SQL : ".$e->getMessage());
        }

        $this->table = get_called_class();
    }


    public function setId(int $id): void
    {
        $this->id = $id;
        $this->getOneBy(["id"=>$id], true);
    }

    public function getOneBy(array $where, $object = false): ?array
    {
        $sqlWhere = [];
        foreach ($where as $key => $value) {
            $sqlWhere[]=$key."=:".$key;
        }
        $sql = " SELECT * FROM ".$this->table." WHERE  ".implode(" AND ", $sqlWhere).";";
        $query = $this->pdo->prepare($sql);
        
        if ($object) {
            $query->setFetchMode(PDO::FETCH_INTO, $this);
        } else {
            $query->setFetchMode(PDO::FETCH_ASSOC);
        }

        try{
            $query->execute($where);
            return $query->fetch();
        } catch (\Exception $exception){
            echo 'Error'.$exception->getMessage();
            return null;
        }

    }

    public function save(): void
    {
        $dataObject = get_object_vars($this);
        $dataChild = array_diff_key($dataObject, get_class_vars(get_class()));

        if (is_null($dataChild["id"])) {
            $sql ="INSERT INTO ".$this->table." ( ".
            implode(",", array_keys($dataChild)) .") VALUES ( :".
            implode(",:", array_keys($dataChild)) .")";

            $query = $this->pdo->prepare($sql);
            $query->execute($dataChild);
        } else {
            $sqlUpdate = [];
            foreach ($dataChild as $key => $value) {
                if ($key != "id") {
                    $sqlUpdate[]=$key."=:".$key;
                }
            }

            $sql ="UPDATE ".$this->table." SET ".implode(",", $sqlUpdate)." WHERE id=:id";

            $query = $this->pdo->prepare($sql);
            $query->execute($dataChild);
        }
    }
}
