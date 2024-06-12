<?php

namespace App\Model;
use PDO;

class UserManager extends AbstractManager
{
    const TABLE = 'user';
    
    public function selectOneByPseudo(string $name): array|false
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . self::TABLE . ' WHERE name=:name');
        $statement->bindValue('name', $name, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public function insert($data)
    {
        $name = $data['name'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user = $this->selectOneByPseudo($name);
        if(!$user)
        {
            $statement = $this->pdo->prepare(
                "INSERT INTO " . self::TABLE . " (`name`, `password`)
                VALUE (:name, :password);"
            );
            $statement->bindValue("name", $name, PDO::PARAM_STR);
            $statement->bindValue("password", $password, PDO::PARAM_STR);
    
            return $statement->execute();
            header('Location: /');
        }
    }
}