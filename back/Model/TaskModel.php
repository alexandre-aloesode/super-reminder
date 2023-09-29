<?php

namespace App\Model;

use App\Model\Abstract\AbstractModel;
require_once 'Abstract/AbstractModel.php';
use DateTime;

class TaskModel extends AbstractModel
{

    private ?int $id;
    private ?int $idUser;
    private ?string $description;
    private ?DateTime $createdAt;
    private ?string $status;

    public function __construct()
    {
        parent::connect();
        $this->tableName = 'tasks';
    }

    public function setTask(int $idTask): object
    {
        $requestUserInfo = "SELECT * FROM tasks WHERE id = :id";
        $queryUserInfo = self::getPdo()->prepare($requestUserInfo);
        $queryUserInfo->execute(['id' => $idTask]);
        $resultUserInfo = $queryUserInfo->fetchAll(\PDO::FETCH_ASSOC);
        $this->id = $resultUserInfo[0]['id'];
        $this->idUser = $resultUserInfo[0]['id_user'];
        $this->description = $resultUserInfo[0]['description'];
        $this->createdAt = $resultUserInfo[0]['created_at'];
        $this->status = $resultUserInfo[0]['status'];
        return $this;
    }

    public function getOneUserTasks(int $idUser): array
    {
        return $this->readOneByForeignKey('id_user', $idUser, 'void');
    }
}
