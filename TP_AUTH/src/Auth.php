<?php

namespace App;

use App\Exceptions\ForbiddenException;
use PDO;

class Auth
{
    /**
     * @var PDO
     */
    private $pdo;

    private $loginPath;

    private $session;

    public function __construct(PDO $pdo, string $loginPath, &$session)
    {
        $this->pdo = $pdo;

        $this->loginPath = $loginPath;

        $this->session = &$session;
    }

    public function user(): ?User
    {
        $id = $this->session['auth'] ?? null;
        if ($id === null) {
            return null;
        }
        $id = (int) $this->session['auth'];
        $query = $this->pdo->prepare("SELECT *FROM users WHERE id = :id");
        $query->execute(['id' => $id]);
        $user = $query->fetchObject(User::class);
        return $user;
    }
    public function login(string $username, string $password): ?User
    {
        $query = $this->pdo->prepare("SELECT *FROM users WHERE username = :username");
        $query->execute([':username' => $username]);
        $query->setFetchMode(PDO::FETCH_CLASS, User::class);
        $user = $query->fetch();
        if ($user === false) {
            return null;
        }
        if (password_verify($password, $user->password)) {
            /* if (session_status === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['auth'] = $user->id; */

            $this->session['auth'] = $user->id;
            return $user;
        }
        return null;
    }

    public function requireRole(string ...$roles)
    {
        $user = $this->user();
        if ($user === null) {

            /* header("Location: {$this->loginPath}?forbid=1");
            exit; */

            throw new ForbiddenException("Vous devez être connecté pour voir cette page");
        }
        if (!in_array($user->role, $roles)) {

            throw new ForbiddenException("Vous n'avez le rôle suffisant pour accéder à cette page");
        }
    }
}
