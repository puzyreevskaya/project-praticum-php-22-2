<?php

namespace tgu\puzyrevskaya\Blog\Http\Actions\Comments;

use tgu\puzyrevskaya\Blog\Comments;
use tgu\puzyrevskaya\Blog\Http\Actions\ActionInterface;
use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\Response;
use tgu\puzyrevskaya\Blog\Http\SuccessResponse;
use tgu\puzyrevskaya\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\HttpException;

class CreateComment implements ActionInterface
{
    public function __construct(
        private CommentsRepositoryInterface $commentsRepository
    )
    {

    }

    public function handle(Request $request): Response
    {
        try {
            $newCommentUuid = UUID::random();
            $comment = new Comments($newCommentUuid, $request->jsonBodyFind('uuid_post'), $request->jsonBodyFind('uuid_author'), $request->jsonBodyFind('textCom'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->commentsRepository->saveComment($comment);
        return new SuccessResponse(['uuid'=>(string)$newCommentUuid]);
    }
}