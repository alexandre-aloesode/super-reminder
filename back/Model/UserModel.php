<?php
namespace App\Model;
use App\Model\Abstract\AbstractModel;   
require_once 'Abstract/AbstractModel.php';


class UserModel extends AbstractModel {

    private ?int $id;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $email;

    public function __construct()
    {
        parent::connect();
        $this->tableName = 'users';
    }

    public function register(array $params) {
        $this->createOne($params);
    }

    public function setSession(string $email): object
    {
        $requestUserInfo = "SELECT * FROM users WHERE email = :email";
        $queryUserInfo = self::getPdo()->prepare($requestUserInfo);
        $queryUserInfo->execute(['email' => $email]);
        $resultUserInfo = $queryUserInfo->fetchAll(\PDO::FETCH_ASSOC);
        $this->id = $resultUserInfo[0]['id'];
        $this->firstName = $resultUserInfo[0]['first_name'];
        $this->lastName = $resultUserInfo[0]['last_name'];
        $this->email = $resultUserInfo[0]['email'];
        $this->password = $resultUserInfo[0]['password'];
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string 
    {
        return $this->firstName;
    }

    public function getLastName(): ?string 
    {
        return $this->lastName;
    }

    public function getEmail(): ?string 
    {
        return $this->email;
    }

    public function getPassword(): ?string 
    {
        return $this->password;
    }

    public function setId(int $id): void 
    {
        $this->id = $id;
    }

    public function setFirstName(string $firstName): void 
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void 
    {
        $this->lastName = $lastName;
    }

    public function setEmail(string $email): void 
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void 
    {
        $this->password = $password;
    }
}
