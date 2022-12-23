<?php

namespace tgu\puzyrevskaya\Blog\Repositories\PostRepositories;

use tgu\puzyrevskaya\Blog\Post;
use tgu\puzyrevskaya\Blog\UUID;

interface PostsRepositoryInterface
{
    public function savePost(Post $post):void;
    public function getByUuidPost(UUID $uuidPost): Post;
}
