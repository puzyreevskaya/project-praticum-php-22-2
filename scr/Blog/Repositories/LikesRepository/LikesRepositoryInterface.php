<?php
namespace tgu\puzyrevskaya\Blog\Repositories\LikesRepository;

use tgu\puzyrevskaya\Blog\Likes;

interface LikesRepositoryInterface
{
    public function saveLike(Likes $comment):void;
    public function getByPostUuid(string $uuid_post): Likes;
}