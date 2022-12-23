<?php

use tgu\puzyrevskaya\Blog\Comments;
use tgu\puzyrevskaya\Blog\Post;
use tgu\puzyrevskaya\Blog\Repositories\PostRepositories\SqlitePostsRepository;
use tgu\puzyrevskaya\Blog\UUID;

use tgu\puzyrevskaya\Blog\Repositories\UserRepository\SqliteUsersRepository;
use tgu\puzyrevskaya\Blog\User;

require_once __DIR__.'/vendor/autoload.php';

$connection=new PDO('sqlite:'.__DIR__.'/blog.sqlite');

$userRepository = new SqliteUsersRepository($connection);
$userRepository->save(new User(\tgu\puzyrevskaya\Blog\UUID::random(), new \tgu\puzyrevskaya\Person\Name('Eugene', 'Tikko'),'admin'));
$userRepository->save(new User(\tgu\puzyrevskaya\Blog\UUID::random(), new \tgu\puzyrevskaya\Person\Name('West', 'Kay'),'user1'));
echo $userRepository->getByUuid(new \tgu\puzyrevskaya\Blog\UUID('cf6cdc15-b2f8-154d-7597-648a8294b64d'));
$PostRepository = new SqlitePostsRepository($connection);
$PostRepository->savePost(new Post(\tgu\puzyrevskaya\Blog\UUID::random(),'d34cd6a4-44a5-3d65-52bb-e3efcb390a0c','Title1','Title1'));
$PostRepository->savePost(new Post(\tgu\puzyrevskaya\Blog\UUID::random(), 'cf6cdc15-b2f8-154d-7597-648a8294b64d', 'title2','title2'));
echo $PostRepository->getByUuidPost(new \tgu\puzyrevskaya\Blog\UUID('b0b10650-eb52-43a8-5a1c-cf167beed5d0'));
$CommentsRepository = new \tgu\puzyrevskaya\Blog\Repositories\CommentsRepository\SqliteCommentsRepository($connection);
$CommentsRepository->saveComment(new Comments(UUID::random(),'b0b10650-eb52-43a8-5a1c-cf167beed5d0', 'cf6cdc15-b2f8-154d-7597-648a8294b64d','Good'));
$CommentsRepository->saveComment(new Comments(UUID::random(), '78a815b7-a3ed-a629-e845-920c0f5a034e', 'd34cd6a4-44a5-3d65-52bb-e3efcb390a0c','Baad'));
echo $CommentsRepository->getByUuidComment(new \tgu\puzyrevskaya\Blog\UUID('f165d492-bffe-448f-a499-b72d16a40f1b'));