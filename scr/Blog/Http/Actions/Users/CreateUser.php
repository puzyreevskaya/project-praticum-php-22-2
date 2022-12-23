<?php

namespace tgu\puzyrevskaya\Blog\Http\Actions\Users;

use tgu\puzyrevskaya\Blog\Http\Actions\ActionInterface;
use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\Response;
use tgu\puzyrevskaya\Blog\Http\SuccessResponse;
use tgu\puzyrevskaya\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use tgu\puzyrevskaya\Blog\User;
use tgu\puzyrevskaya\Exceptions\HttpException;
use tgu\puzyrevskaya\Person\Name;

class CreateUser implements ActionInterface
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    )
    {
        
    }

    public function handle(Request $request): Response
    {
        try {
                $user= User::createFrom(
                $request->jsonBodyField('username'),
                $request->jsonBodyField('password'),
                new Name(
                    $request->jsonBodyField('first_name'),
                    $request->jsonBodyField('last_name')
                )
            );

        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->usersRepository->save($user);
        return new SuccessResponse(['uuid'=>(string)$user->getUuid(),
            ]);
    }

}