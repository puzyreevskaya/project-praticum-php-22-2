<?php

namespace tgu\puzyrevskaya\Blog\Repositories\UserRepository;

use tgu\puzyrevskaya\Blog\User;
use tgu\puzyrevskaya\Blog\UUID;

interface UsersRepositoryInterface
{
    public function save(User $user):void;
    public function getByUsername(string $username):User;
    public function getByUuid(UUID $uuid): User;
}
