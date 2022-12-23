<?php

namespace tgu\puzyrevskaya\Blog\Http\Actions\Posts;

use tgu\puzyrevskaya\Blog\Http\Actions\ActionInterface;
use tgu\puzyrevskaya\Blog\Http\Auth\TokenAuthenticationInterface;
use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\Response;
use tgu\puzyrevskaya\Blog\Http\SuccessResponse;
use tgu\puzyrevskaya\Blog\Post;
use tgu\puzyrevskaya\Blog\Repositories\PostRepositories\PostsRepositoryInterface;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\HttpException;
use tgu\puzyrevskaya\Exceptions\UserNotFoundException;

class CreatePost implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository,
        private TokenAuthenticationInterface $authentication,

    )
    {

    }

    /**
     * @throws HttpException
     */
    public function handle(Request $request): Response
    {
     try {
         $uuid_author = $this->authentication->user($request);
    } catch (UserNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
    }


        $newPostUuid = UUID::random();
        try {
            $post = new Post($newPostUuid,
                $uuid_author,
                $request->jsonBodyField('title'),
                $request->jsonBodyField('text'));
        } catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        $this->postsRepository->savePost($post);
        return new SuccessResponse(['uuid_post'=>(string)$newPostUuid]);

    }
}