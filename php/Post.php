<?php
class Post
{
    public $id;

    public $name;

    public $content;

    public function getExcerpt(): string
    {
        return substr($this->content, 0, 100) . '...';
    }
}
