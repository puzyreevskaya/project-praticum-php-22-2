<?php

namespace tgu\puzyrevskaya\Blog;

class Likes
{
    public function __construct(
        private UUID $idLike,
        private string $id_post,
        private string $id_us,
    )
    {
    }
    public function __toString(): string
    {
        $idLike=$this->getUuidLike();
        return "Like - $idLike on post $this->id_post where user - $this->id_author".PHP_EOL;
    }
    public function getUuidLike():UUID{
        return $this->idLike;
    }
    public function getUuidPost():string{
        return $this->id_post;
    }
    public function getUuidUser():string{
        return $this->id_us;
    }
}