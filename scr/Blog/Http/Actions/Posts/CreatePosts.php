<?php

namespace tgu\puzyrevskaya\Blog\Http\Actions\Posts;

use tgu\puzyrevskaya\Blog\Http\Actions\ActionInterface;
use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\Response;
use tgu\puzyrevskaya\Blog\Http\SuccessResponse;
use tgu\puzyrevskaya\Blog\Repositories\PostRepositories\PostsRepositoryInterface;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\HttpException;
use tgu\puzyrevskaya\Exceptions\PostNotFoundException;

class CreatePosts implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $uuid = UUID::random();
            $id = $request->query('uuid_post');
            $post = $this->postsRepository->getByUuidPost($uuid);
        }
        catch (HttpException | PostNotFoundException $exception ){
            return new ErrorResponse($exception->getMessage());
        }
        $this->postsRepository->savePost($post);
        return new SuccessResponse(['uuid_post'=>$id, 'uuid_author'=>$post->getUuidUser(), 'title'=>$post->getTitle(), 'text'=>$post->getTextPost()]);
    }
}