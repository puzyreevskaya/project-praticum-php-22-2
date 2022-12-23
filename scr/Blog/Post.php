<?php
namespace tgu\puzyrevskaya\Blog;

class Post extends \tgu\puzyrevskaya\Blog\User
{
    public function __construct(
        private UUID $id,
        private User $id_author,
        private string $header,
        private string $text,
    )
    {
    }

    public function __toString(): string
    {
        $id=$this->getUuidPost();
        return $this->id_author->getUserName() . 'пишет: ' . PHP_EOL . $this->header . PHP_EOL . $this->text;
    }
    public function getUuidPost():UUID{
        return $this->id;
    }
    public function getUuidUser():string{
        return $this->id_author;
    }
    public function getTitle():string{
        return $this->header;
    }
    public function getTextPost():string{
        return $this->text;
    }
}