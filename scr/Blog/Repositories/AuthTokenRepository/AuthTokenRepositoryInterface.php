<?php

namespace tgu\puzyrevskaya\Blog\Repositories\AuthTokenRepository;

use tgu\puzyrevskaya\Blog\AuthToken;

interface AuthTokenRepositoryInterface
{
    public function save(AuthToken $authToken): void;
    public function get(string $token): AuthToken;
}