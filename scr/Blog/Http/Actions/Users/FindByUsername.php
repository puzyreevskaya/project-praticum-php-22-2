<?php

namespace tgu\puzyrevskaya\Blog\Http\Actions\Users;

use tgu\puzyrevskaya\Blog\Http\Actions\ActionInterface;
use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\Response;
use tgu\puzyrevskaya\Blog\Http\SuccessResponse;
use tgu\puzyrevskaya\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use tgu\puzyrevskaya\Exceptions\HttpException;
use tgu\puzyrevskaya\Exceptions\UserNotFoundException;

class FindByUsername implements ActionInterface
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $username = $request->query('username');
            $user =$this->usersRepository->getByUsername($username);
        }
        catch (HttpException | UserNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        return new SuccessResponse(['username'=>$user->getUserName(),'name'=>$user->getName()->getFirstName().' '.$user->getName()->getLastName()]);
    }
}