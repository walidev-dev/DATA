<?php

namespace App\Tables;


use App\Entities\Post;
use Core\Table;

class PostTable extends Table
{
    protected $classMapping = Post::class;

    public function getLast()
    {
        return $this->db->query("
            SELECT post.id,post.titre,post.contenu,category.nom as categorie 
            FROM post
            LEFT JOIN category
            ON category_id = category.id
            ORDER BY post.date DESC", $this->classMapping);
    }

    public function lastByCategory($id)
    {
        return $this->db->prepare("
            SELECT post.titre,post.contenu
            FROM post
            LEFT JOIN category
                ON category_id = category.id
            WHERE category.id = :id
            ORDER BY post.date DESC", [':id' => $id], $this->classMapping, false);
    }
}
