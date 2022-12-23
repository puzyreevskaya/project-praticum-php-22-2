<?php

namespace tgu\puzyrevskaya\Blog\Repositories\CommentsRepository;


use tgu\puzyrevskaya\Blog\Comments;
use tgu\puzyrevskaya\Blog\UUID;

interface CommentsRepositoryInterface
{
    public function saveComment(Comments $comment):void;
    public function getByUuidComment(UUID $uuid_comment): Comments;
}

