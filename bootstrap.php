<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use tgu\puzyrevskaya\Blog\Container\DIContainer;
use tgu\puzyrevskaya\Blog\Http\Auth\BearerTokenAuthentication;
use tgu\puzyrevskaya\Blog\Http\Auth\PasswordAuthentication;
use tgu\puzyrevskaya\Blog\Http\Auth\PasswordAuthenticationInterface;
use tgu\puzyrevskaya\Blog\Http\Auth\TokenAuthenticationInterface;
use tgu\puzyrevskaya\Blog\Repositories\AuthTokenRepository\AuthTokenRepositoryInterface;
use tgu\puzyrevskaya\Blog\Repositories\AuthTokenRepository\SqliteAuthTokenRepository;
use tgu\puzyrevskaya\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use tgu\puzyrevskaya\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use tgu\puzyrevskaya\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use tgu\puzyrevskaya\Blog\Repositories\LikesRepository\SqliteLikesRepository;
use tgu\puzyrevskaya\Blog\Repositories\PostRepositories\PostsRepositoryInterface;
use tgu\puzyrevskaya\Blog\Repositories\PostRepositories\SqlitePostsRepository;
use tgu\puzyrevskaya\Blog\Repositories\UserRepository\SqliteUsersRepository;
use tgu\puzyrevskaya\Blog\Repositories\UserRepository\UsersRepositoryInterface;

require_once  __DIR__ . '/vendor/autoload.php';
$conteiner = new DIContainer();
$conteiner->bind(
    PDO::class,
    new PDO('sqlite:'.__DIR__.'/blog.sqlite')
);
$conteiner->bind(
    UsersRepositoryInterface::class,
    SqliteUsersRepository::class
);
$conteiner->bind(
    TokenAuthenticationInterface::class,
    BearerTokenAuthentication::class
);

$conteiner->bind(
    PasswordAuthenticationInterface::class,
    PasswordAuthentication::class
);
$conteiner->bind(
    LikesRepositoryInterface::class,
    SqliteLikesRepository::class
);

$conteiner->bind(
    AuthTokenRepositoryInterface::class,
    SqliteAuthTokenRepository::class
);

$conteiner->bind(
    PostsRepositoryInterface::class,
    SqlitePostsRepository::class
);
$conteiner->bind(
    CommentsRepositoryInterface::class,
    SqliteCommentsRepository::class
);

$conteiner->bind(
    LoggerInterface::class,
    (new Logger('blog'))->pushHandler(new StreamHandler(
        __DIR__.'/logs/blog.log',
    )) ->pushHandler(new StreamHandler(
        __DIR__.'/logs/blog.error.log',
        level: Logger::ERROR,
        bubble: false
    ))->pushHandler(new StreamHandler( "php://stdout"),
    ),
);
return $conteiner;