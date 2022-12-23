<?php

namespace tgu\puzyrevskaya\Blog\Http\Actions;

use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\Response;
use tgu\puzyrevskaya\Blog\Http\SuccessResponse;
use tgu\puzyrevskaya\Blog\Likes;
use tgu\puzyrevskaya\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\HttpException;

class CreateLikes implements ActionInterface
{
    public function __construct(
        private LikesRepositoryInterface $likesRepository
    )
    {
    }
    public function handle(Request $request): Response
    {
        try {
            $newLikeUuid = UUID::random();
            $like= new Likes($newLikeUuid, $request->jsonBodyFind('uuid_post'), $request->jsonBodyFind('uuid_user'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->likesRepository->saveLike($like);
        return new SuccessResponse(['uuid_like'=>(string)$newLikeUuid]);
    }
}