<?php

namespace tgu\puzyrevskaya\Blog\Http\Auth;

use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Post;
use tgu\puzyrevskaya\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use tgu\puzyrevskaya\Blog\User;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\AuthException;
use tgu\puzyrevskaya\Exceptions\HttpException;
use tgu\puzyrevskaya\Exceptions\InvalidArgumentExceptions;
use tgu\puzyrevskaya\Exceptions\UserNotFoundException;

class PasswordAuthentication implements PasswordAuthenticationInterface
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository,
    )
    {

    }

    /**
     * @throws AuthException
     */
    public function user(Request $request): User
    {
        try {
            $username = new UUID($request->jsonBodyField('username'));
        }catch (InvalidArgumentExceptions | HttpException$exception){
            throw new AuthException($exception->getMessage());
        }
        try {
            $user = $this->usersRepository->getByUsername($username);
        }catch (UserNotFoundException $exception){
            throw new AuthException($exception->getMessage());
        }
        try {
            $password = $request->jsonBodyField('password');
        }catch (InvalidArgumentExceptions | HttpException$exception){
            throw new AuthException($exception->getMessage());
        }


      if (!$user->checkPassword($password)){
           throw new AuthException('Wrong password');
      }
             return $user;
    }

    public function post(Request $request): Post
    {
        // TODO: Implement post() method.
    }
}