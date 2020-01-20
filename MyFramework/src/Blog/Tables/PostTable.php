<?php

namespace App\Blog\Tables;

use App\Blog\Entities\Post;
use Framework\Table;

class PostTable extends Table
{
    protected $classMapping = Post::class;

}
