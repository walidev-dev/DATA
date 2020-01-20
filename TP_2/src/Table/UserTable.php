<?php

namespace App\Table;

use App\Models\User;
use App\Table\Exceptions\NotFoundException;

class UserTable extends Table
{

    public function findByUsername(string $username)
    {
        $query = $this->pdo->prepare("SELECT * FROM user WHERE username = :username");
        $query->execute(['username' => $username]);
        $result = $query->fetchObject(User::class);
        if ($result === false) {
            throw new NotFoundException('user', $username);
        }
        return $result;
    }
}
