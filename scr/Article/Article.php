<?php
namespace tgu\puzyrevskaya\Article;

use tgu\puzyrevskaya\Person\Person;


class Article
{
    public $id;
    public $id_author;
    public $headname;
    public $content;

    public function __construct($id, $id_author, $headname, $content)
    {
        $this->id = $id;
        $this->id_author = $id_author;
        $this->headname = $headname;
        $this->content = $content;
    }
}
?>