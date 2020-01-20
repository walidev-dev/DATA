<?php

namespace App\Models;

class Category
{
    private $id;
    private $name;
    private $slug;
    private $post;

    public function toArray(): array
    {
        $t['id'] = $this->getID();
        $t['name'] = $this->getName();
        $t['slug'] = $this->getSlug();
        return $t;
    }
    public function getID(): ?int
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }
    public function setPost(Post $post)
    {
        $this->post = $post;
    }
    public function getPost()
    {
        return $this->post;
    }

    public static function arrayToHTML(Post $post, $router)
    {
        $categories_html = array_map(function ($category) use ($router) {
            $url = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
            $categoryName = htmlentities($category->getName());
            return <<<HTML
            <a href="{$url}">{$categoryName}</a>
HTML;
        }, $post->getCategories());

        return $categories_html;
    }
}
