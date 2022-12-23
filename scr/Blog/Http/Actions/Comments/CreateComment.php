<?php

namespace tgu\puzyrevskaya\Blog\Http\Actions\Comments;

use tgu\puzyrevskaya\Blog\Comments;
use tgu\puzyrevskaya\Blog\Http\Actions\ActionInterface;
use tgu\puzyrevskaya\Blog\Http\Auth\TokenAuthenticationInterface;
use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\Response;
use tgu\puzyrevskaya\Blog\Http\SuccessResponse;
use tgu\puzyrevskaya\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\HttpException;
use tgu\puzyrevskaya\Exceptions\PostNotFoundException;
use tgu\puzyrevskaya\Exceptions\UserNotFoundException;

class CreateComment implements ActionInterface
{
    public function __construct(
        private CommentsRepositoryInterface $commentsRepository,
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

        $newCommentUuid = UUID::random();
        try {
            $comment = new Comments($newCommentUuid,
                $uuid_post,
                $uuid_author,
                $request->jsonBodyField('textCom')
               );
        } catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        $this->commentsRepository->saveComment($comment);
        return new SuccessResponse(['uuid_comment'=>(string)$newCommentUuid]);

    }
}