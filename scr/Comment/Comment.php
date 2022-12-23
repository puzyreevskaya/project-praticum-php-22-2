<?php

namespace tgu\puzyrevskaya\Comment;

use tgu\puzyrevskaya\Person\Person;
use tgu\puzyrevskaya\Article\Article;

class Comment
{
    public $id;
    public $id_author;
    public $id_article;
    public $content;

    public function __construct($id, $id_author, $id_article, $content)
    {
        $this->id = $id;
        $this->id_author = $id_author;
        $this->id_article = $id_article;
        $this->content = $content;
    }
}

?>