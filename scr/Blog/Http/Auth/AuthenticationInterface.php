<?php

namespace tgu\puzyrevskaya\Blog\Http\Auth;

use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Post;
use tgu\puzyrevskaya\Blog\User;

interface AuthenticationInterface
{
    public function user(Request $request):User;
    public function post(Request $request):Post;

}

