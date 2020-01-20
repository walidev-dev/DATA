<?php

namespace App\Table;

use App\Models\Post;
use App\PaginatedQuery;


class PostTable extends Table
{

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM post_category WHERE post_id = :post_id");
        $query->execute([':post_id' => $id]);
        $this->deleteById($id);
    }

    public function update(Post $post, array $categoriesID): void
    {
        $query = $this->pdo->prepare("UPDATE post SET name = :name,slug = :slug,content = :content WHERE id = :id");
        $query->execute(
            [
                ':id' => $post->getID(),
                ':name' => $post->getName(),
                ':slug' => $post->getSlug(),
                ':content' => $post->getContent()
            ]
        );
        $this->pdo->exec("DELETE FROM post_category WHERE post_id =" . $post->getID());
        foreach ($categoriesID as $categoryID) {
            $query = $this->pdo->prepare("INSERT post_category SET post_id =:post_id,category_id = :category_id");
            $query->execute(
                [
                    ':post_id' => $post->getID(),
                    ':category_id' => $categoryID,
                ]
            );
        }
    }

    public function create(Post $post, array $categoriesID): void
    {
        $query = $this->pdo->prepare("INSERT post SET name = :name,slug = :slug,content = :content,created_at = :created_at");
        $query->execute(
            [
                ':name' => $post->getName(),
                ':slug' => $post->getSlug(),
                ':content' => $post->getContent(),
                ':created_at' => $post->getCreatedAt()->format("Y-m-d H:i")
            ]
        );
        $post_id = $this->pdo->lastInsertId();
        foreach ($categoriesID as $categoryID) {
            $query = $this->pdo->prepare("INSERT post_category SET post_id =:post_id,category_id = :category_id");
            $query->execute(
                [
                    ':post_id' => $post_id,
                    ':category_id' => $categoryID,
                ]
            );
        }
    }



    public function findPaginated()
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM post ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM post",
            $this->pdo
        );
        /** @var Post[] */
        $posts = $paginatedQuery->getItems(Post::class);

        /* RÉCUPERER LES CATEGORIES LIÉES À CHAQU'UN DES 12 ARTICLES */

        (new CategoryTable($this->pdo))->hydratePosts($posts);

        return [$posts, $paginatedQuery];
    }

    public function findPaginatedByCategory(int $id)
    {

        $paginatedQuery = new PaginatedQuery(
            "SELECT p.id,p.name,p.created_at,p.content,p.slug
            FROM post p
            LEFT JOIN post_category pc
            ON p.id=pc.post_id
            WHERE pc.category_id = {$id}
            ORDER BY p.created_at DESC
            ",
            "SELECT COUNT(p.id) 
            FROM post p
            LEFT JOIN post_category pc
            ON p.id = pc.post_id
            WHERE pc.category_id = {$id}"

        );

        $posts = $paginatedQuery->getItems(Post::class);

        (new CategoryTable($this->pdo))->hydratePosts($posts);

        return [$posts, $paginatedQuery];
    }
}
