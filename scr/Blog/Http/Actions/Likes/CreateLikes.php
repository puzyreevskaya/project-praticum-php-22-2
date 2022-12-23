<?php

namespace tgu\puzyrevskaya\Blog\Http\Actions\Likes;

use tgu\puzyrevskaya\Blog\Http\Actions\ActionInterface;
use tgu\puzyrevskaya\Blog\Http\Auth\TokenAuthenticationInterface;
use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\Response;
use tgu\puzyrevskaya\Blog\Http\SuccessResponse;
use tgu\puzyrevskaya\Blog\Likes;
use tgu\puzyrevskaya\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\HttpException;
use tgu\puzyrevskaya\Exceptions\PostNotFoundException;
use tgu\puzyrevskaya\Exceptions\UserNotFoundException;

class CreateLikes implements ActionInterface
{
    public function __construct(
        private LikesRepositoryInterface $likesRepository,
        private TokenAuthenticationInterface $authentication,
    )
    {
    }
    public function handle(Request $request): Response
    {
        try {
            $uuid_author = $this->authentication->user($request);
        } catch (UserNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        try {
            $uuid_post = $this->authentication->post($request);
        } catch (PostNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $newLikeUuid = UUID::random();
        try {
            $like = new Likes($newLikeUuid,
                $uuid_post,
                $uuid_author,
            );
        } catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        $this->likesRepository->saveLike($like);
        return new SuccessResponse(['uuid_like'=>(string)$newLikeUuid]);
//
    }
}