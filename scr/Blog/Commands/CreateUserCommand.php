<?php

namespace tgu\puzyrevskaya\Blog\Commands;

use tgu\puzyrevskaya\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use tgu\puzyrevskaya\Blog\User;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\CommandException;
use tgu\puzyrevskaya\Exceptions\UserNotFoundException;
use tgu\puzyrevskaya\Person\Name;

class CreateUserCommand
{
    public function handle(Arguments $arguments):void{
        $username = $arguments->get('username');
        if($this->userExist($username)){
            throw new CommandException("User already exists: $username");
        }
        $this->usersRepository->save(new User(UUID::random(), new Name($arguments->get('first_name'), $arguments->get('last_name')),$username));
    }
    public function userExist(string $username):bool{
        try{
            $this->usersRepository->getByUsername($username);
        }
        catch (UserNotFoundException $exception){
            return false;
        }
        return true;
    }
}