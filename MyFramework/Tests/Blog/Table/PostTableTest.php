<?php

namespace Tests\Blog\Table;

use App\Blog\Entities\Post;
use App\Blog\Tables\PostTable;
use PDO;
use PHPUnit\Framework\TestCase;

class PostTableTest extends TestCase
{
    /**
     * @var PostTable $postTable
     */
    private $postTable;

    public function setUp()
    {
        $pdo = new PDO('sqlite::memory:', null, null, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $pdo->exec('CREATE TABLE post(id int,name VARCHAR(255),created_at DATETIME)');
        $pdo->exec('INSERT INTO post(id,name) VALUES(1,"article de test")');
        $pdo->exec('INSERT INTO post(id,name) VALUES(2,"deuxiéme article de test")');
        $this->postTable = new PostTable($pdo);
    }

    public function tearDown()
    {
        $this->postTable = null;
    }

    public function testGetOne()
    {
        $post = $this->postTable->getOne(1);
        $this->assertInstanceOf(Post::class, $post);
    }

    public function testGetAll(){
        $posts = $this->postTable->getAll();
        $this->assertCount(2,$posts);
    }
}