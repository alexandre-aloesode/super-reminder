<?php

namespace App\Model\Abstract;

abstract class AbstractModel
{

    protected string $tableName;
    protected ?string $password = null;
    protected static $pdo;
    public function __construct()
    {
    }

    public static function connect()
    {
        $password = (PHP_OS == 'Linux') ? '' : 'root';
        // $pleskPassword = 'eShop123!';
        $dsn = 'mysql:host=localhost;dbname=super-reminder;charset=utf8';
        // $pleskdsn = 'mysql:host=localhost;dbname=alexandre-aloesode_eShop;charset=utf8';
        self::$pdo = new \PDO($dsn, 'root', $password);
        // self::$pdo = new \PDO($pleskdsn, 'eShop', $pleskPassword);
    }

    protected static function getPdo()
    {
        if (!self::$pdo) {
            self::connect();
        }
        return self::$pdo;
    }

    public function createOne(array $params)
    {
        $fieldsName = implode(', ', array_keys($params));
        $fieldsName = str_replace(':', '', $fieldsName);
        $fieldsSqlValue = implode(', ', array_keys($params));
        $requestCreateOne = "INSERT INTO $this->tableName ($fieldsName) VALUES ($fieldsSqlValue)";
        $queryCreateOne = self::getPdo()->prepare($requestCreateOne);
        $result = $queryCreateOne->execute($params);
        return $result;
    }

    public function readOneByString(string $input, string $fieldName): array
    {
        $requestReadOne = "SELECT * FROM $this->tableName WHERE $fieldName = :$fieldName";
        $queryReadOne = self::getPdo()->prepare($requestReadOne);
        $queryReadOne->execute([$fieldName => $input]);
        $resultReadOne = $queryReadOne->fetchAll(\PDO::FETCH_ASSOC);
        return $resultReadOne;
    }

    public function readOneByForeignKey(string $foreignKey, int $keyValue, $order): array
    {
        if($order == "void") {       
        $requestReadOne = "SELECT * FROM $this->tableName WHERE $foreignKey = :$foreignKey";
        }
        else {
            $requestReadOne = "SELECT * FROM $this->tableName WHERE $foreignKey = :$foreignKey ORDER BY $order";
        }
        $queryReadOne = self::getPdo()->prepare($requestReadOne);
        $queryReadOne->execute([':' . $foreignKey => $keyValue]);
        $resultReadOne = $queryReadOne->fetchAll();
        return $resultReadOne;
    }

    public function readOneByDoubleForeignKey(string $foreignKey1, int $keyValue1, string $foreignKey2, int $keyValue2, $order): array
    {
        if($order == "void") {       
        $requestReadOne = "SELECT * FROM $this->tableName WHERE $foreignKey1 = :$foreignKey1 AND $foreignKey2 = :$foreignKey2";
        }
        else {
            $requestReadOne = "SELECT * FROM $this->tableName WHERE $foreignKey1 = :$foreignKey1 AND $foreignKey2 = :$foreignKey2 ORDER BY $order";
        }
        $queryReadOne = self::getPdo()->prepare($requestReadOne);
        $queryReadOne->execute([
            ':' . $foreignKey1 => $keyValue1,
            ':' . $foreignKey2 => $keyValue2
        ]);
        $resultReadOne = $queryReadOne->fetchAll(\PDO::FETCH_ASSOC);
        return $resultReadOne;
    }

    public function updateOne(array $params)
    {

        //Récupération des params puis suppression du dernier élément du tableau, à savoir l'id, qu'on ne veut pas update
        $fieldsToUpdate = $params;
        array_pop($fieldsToUpdate);

        //Création du tableau dans lequel stocker notre string de requête d'update
        $requestString = [];

        //Boucle pour alimenter notre tableau
        foreach ($fieldsToUpdate as $key => $value) {

            $fieldName = str_replace(':', '', $key);
            $requestString[] = $fieldName . ' = ' . $key;
        }

        //Conversion du tableau en string
        $requestString = implode(', ', $requestString);

        $requestUpdateOne = "UPDATE $this->tableName SET $requestString WHERE id = :id";

        $queryUpdateOne = self::getPdo()->prepare($requestUpdateOne);

        $queryUpdateOne->execute($params);
    }

    public function deleteOne(array $params)
    {
        $fieldsArray = [];
        foreach ($params as $key => $value) {
            $fieldsArray[] = $key;
        }

        $input1 = $fieldsArray[0];
        $fieldName1 = str_replace(':', '', $input1);

        if (count($fieldsArray) > 1) {
            $input2 = $fieldsArray[1];
            $fieldName2 = str_replace(':', '', $input2);
            $requestDeleteOne = "DELETE FROM $this->tableName WHERE $fieldName1 = $input1 AND $fieldName2 = $input2";
        } else {
            $requestDeleteOne = "DELETE FROM $this->tableName WHERE $fieldName1 = $input1";
        }
        $queryDeleteOne = self::getPdo()->prepare($requestDeleteOne);
        $queryDeleteOne->execute($params);
    }
}

?>