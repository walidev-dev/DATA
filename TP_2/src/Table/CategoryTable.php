<?php

namespace App\Table;

use App\Models\Category;
use App\PaginatedQuery;
use PDO;

class CategoryTable extends Table
{
    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM post_category WHERE category_id = :category_id");
        $query->execute([':category_id' => $id]);
        $this->deleteById($id);
    }

    public function update(Category $category): void
    {
        $query = $this->pdo->prepare("UPDATE category SET name = :name,slug = :slug WHERE id = :id");
        $query->execute(
            [
                ':id' => $category->getID(),
                ':name' => $category->getName(),
                ':slug' => $category->getSlug()

            ]
        );
    }

    public function create(Category $category): void
    {
        $query = $this->pdo->prepare("INSERT category SET name = :name,slug = :slug");
        $query->execute(
            [
                ':name' => $category->getName(),
                ':slug' => $category->getSlug()
            ]
        );
    }

    /**
     * @param App\Models\Post[] $posts
     */
    public function hydratePosts(array $posts): void
    {
        /* HYDRATATION DE L'ENTITÉ POST - REMPLIR LA PROPRIÉTÉ CATEGORIES DE L'ENTITÉ POST */

        foreach ($posts as $post) {
            $ids[] = $post->getID();
        }

        $categories = $this->pdo
            ->query("
                SELECT c.*,pc.post_id
                FROM category c
                LEFT JOIN post_category pc
                    ON c.id = pc.category_id
                WHERE pc.post_id IN (" . implode(',', $ids) . ")    
    ")->fetchAll(PDO::FETCH_CLASS, Category::class);

        foreach ($posts as $post) {
            foreach ($categories as $category) {
                if ($post->getID() === $category->post_id) {
                    $post->addCategory($category);
                }
            }
        }
    }

    public function findPaginated()
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM category",
            "SELECT COUNT(id) FROM category",
            $this->pdo
        );
        /** @var Category[] */
        $categories = $paginatedQuery->getItems(Category::class);


        return [$categories, $paginatedQuery];
    }

    public function list()
    {
        $categories = $this->pdo
            ->query("SELECT id,name FROM category")
            ->fetchAll(PDO::FETCH_CLASS, Category::class);
        $options = [];
        foreach ($categories as $category) {
            $options[$category->getID()] = $category->getName();
        }
        return $options;
    }
}
