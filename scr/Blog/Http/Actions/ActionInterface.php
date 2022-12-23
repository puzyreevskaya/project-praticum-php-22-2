<?php

namespace tgu\puzyrevskaya\Blog\Http\Actions;

use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\Response;

interface ActionInterface
{
    public function handle(Request $request):Response;
}
