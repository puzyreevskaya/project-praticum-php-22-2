<?php

namespace tgu\puzyrevskaya\PhpUnit\Blog\Http\Auth;

use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\User;

interface AuthenticationInterface
{
    public function user(Request $request): User;
}