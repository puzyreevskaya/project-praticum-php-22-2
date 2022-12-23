<?php

use Dotenv\Dotenv;
use Psr\Log\LoggerInterface;
use tgu\puzyrevskaya\Blog\Http\Actions\Comments\CreateComment;
use tgu\puzyrevskaya\Blog\Http\Actions\Likes\CreateLikes;
use tgu\puzyrevskaya\Blog\Http\Actions\Posts\CreatePost;
use tgu\puzyrevskaya\Blog\Http\Actions\Users\CreateUser;
use tgu\puzyrevskaya\Blog\Http\Actions\Users\FindByUsername;
use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\Actions\Auth\Login;
use tgu\puzyrevskaya\Exceptions\HttpException;


require_once __DIR__ .'/vendor/autoload.php';

Dotenv::createImmutable(__DIR__)->safeLoad();

var_dump($_SERVER);
die;
$conteiner = require __DIR__ .'/bootstrap.php';
$request = new Request($_GET,$_SERVER,file_get_contents('php://input'));
$logger= $conteiner->get(LoggerInterface::class);
try{
    $path=$request->path();
}
catch (HttpException $exception){
    $logger->warning($exception->getMessage());
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
try {
    $method = $request->method();
}
catch (HttpException $exception){
    $logger->warning($exception->getMessage());
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
$routes =[
    'GET'=>['/users/show'=>FindByUsername::class,
    ],
    'POST'=>[
        '/login'=> Login::class,
        '/users/create'=>CreateUser::class,
        '/posts/create'=> CreatePost::class,
        '/comment/create'=> CreateComment::class,
        '/like/create'=> CreateLikes::class,
    ],
];


if (!array_key_exists($path,$routes[$method])){
    $message = "Route not found: $path $method";
    $logger->warning($message);
    (new ErrorResponse($message))->send();
    return;
}
$actionClassName = $routes[$method][$path];
$action = $conteiner->get($actionClassName);
try {
    $response = $action->handle($request);
    $response->send();
}
catch (Exception $exception){
    $logger->warning($exception->getMessage());
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
