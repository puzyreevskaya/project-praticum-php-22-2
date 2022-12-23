<?php

namespace tgu\puzyrevskaya\Blog\Repositories\PostRepositories;

use tgu\puzyrevskaya\Blog\Post;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\PostNotFoundException;

class InMemoryPostRepository implements PostsRepositoryInterface
{
    private array $posts = [];

    public function savePost(Post $post):void{
        $this->posts[] = $post;
    }

    public function getByUuidPost(UUID $uuidPost): Post
    {
        foreach ($this->posts as $post){
            if((string)$post->getUuid() === $uuidPost)
                return $post;
        }
        throw new PostNotFoundException("Posts not found $uuidPost");
    }

    public function getTextPost(string $text): Post
    {

    }
}