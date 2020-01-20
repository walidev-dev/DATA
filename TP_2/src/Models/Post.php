<?php

namespace App\Models;

use App\Helpers\Text;
use DateTime;

class Post
{
    private $id;

    private $name;

    private $slug;

    private $content;

    private $created_at;

    private $categories = [];

    public function __construct()
    {
        $this->created_at = date("Y-m-d H:i");
    }

    public function toArray(): array
    {
        $t['id'] = $this->getID();
        $t['name'] = $this->getName();
        $t['content'] = $this->getContent();
        $t['slug'] = $this->getSlug();
        $t['date'] = $this->getCreatedAt()->format("d/m/Y H:i");
        return $t;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getFormattedContent()
    {
        return nl2br(htmlentities($this->content));
    }

    public function getExcerpt(): ?string
    {
        if ($this->content === null) {
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content)));
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    public function getID()
    {
        return $this->id;
    }
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }

    /**
     * @var Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function getCategoriesID()
    {
        $categoriesID_post = [];
        foreach ($this->getCategories() as $category) {
            $categoriesID_post[] = $category->getID();
        }
        return $categoriesID_post;
    }
}
