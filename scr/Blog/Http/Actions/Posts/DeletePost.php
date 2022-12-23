<?php

namespace tgu\puzyrevskaya\Blog\Http\Actions\Posts;

use tgu\puzyrevskaya\Blog\Http\Actions\ActionInterface;
use tgu\puzyrevskaya\Blog\Http\Auth\AuthenticationInterface;
use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\Response;
use tgu\puzyrevskaya\Blog\Http\SuccessResponse;
use tgu\puzyrevskaya\Blog\Repositories\PostRepositories\PostsRepositoryInterface;
use tgu\puzyrevskaya\Exceptions\HttpException;
use tgu\puzyrevskaya\Exceptions\PostNotFoundException;

class DeletePost implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository
    )
    {
    }
    public function handle(Request $request): Response
    {
        try {
            $uuid = $request->query('uuid_post');
        }
        catch (HttpException | PostNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->postsRepository->getByUuidPost($uuid);
        return new SuccessResponse(['uuid_post'=>$uuid]);
    }
}