<?php

use PHPUnit\Framework\TestCase;

use App\Auth;
use App\Exceptions\ForbiddenException;
use App\User;


class AuthTest extends TestCase
{

    /**
     * @var PDO
     */
    private $pdo = null;

    /**
     * @var Auth
     */
    private $auth;

    private $session = [];

    /**
     * @before
     */
    public function setAuth(): void
    {
        $this->pdo = (is_null($this->pdo)) ? $this->getPDO() : $this->pdo;

        $this->auth = new Auth($this->pdo, 'login.php', $this->session);
    }

    public function getPDO(): PDO
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->query("CREATE TABLE users (id INTEGER,username TEXT,password TEXT,role TEXT)");

        for ($i = 0; $i < 10; $i++) {
            $password = password_hash("user$i", PASSWORD_BCRYPT, ['cost' => 4]);
            $pdo->query("INSERT INTO users (id,username, password,role) VALUES ($i,'user$i' ,'$password','role$i')");
        }

        return $pdo;
    }

    public function testLoginSuccess()
    {

        //$this->pdo->query("DROP TABLE users");


        $user = $this->pdo->query("SELECT *FROM users WHERE username = 'user0'")->fetchObject(User::class);
        $user_ = $this->auth->login('user0', 'user0');

        $this->assertEquals(0, $this->session['auth']);

        $this->assertInstanceOf(User::class, $user_);
        $this->assertObjectHasAttribute("username", $user_);
        $this->assertEquals($user, $user_);
    }

    public function testLoginWithBadPassword()
    {
        $this->assertNull($this->auth->login('user0', 'aze'));
    }

    public function testLoginWithBadUsername()
    {
        $this->assertNull($this->auth->login('aze', 'user0'));
    }

    public function testUserExists()
    {
        $this->session['auth'] = 0;
        $user = $this->auth->user();
        $this->assertIsObject($user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals("user0", $user->username);
    }

    public function testUserWhenNonConnected()
    {
        $this->session['auth'] = null;
        $this->assertNull($this->auth->user());
    }

    public function testRequireRole()
    {
        $this->session['auth'] = 1;
        $this->auth->requireRole('role1');
        $this->expectNotToPerformAssertions();
    }

    public function testRequireRoleThrowException()
    {
        $this->expectException(ForbiddenException::class);
        $this->session['auth'] = 2;
        $this->auth->requireRole('role3');
    }
}
