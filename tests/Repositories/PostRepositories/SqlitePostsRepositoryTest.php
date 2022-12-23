<?php

namespace tgu\puzyrevskaya\PhpUnit\Repositories\PostRepositories;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use tgu\puzyrevskaya\Blog\Post;
use tgu\puzyrevskaya\Blog\Repositories\PostRepositories\SqlitePostsRepository;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\PostNotFoundException;

class SqlitePostsRepositoryTest extends TestCase
{
    public function testItTrowsAnExceptionWhenPostNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostsRepository($connectionStub);

        $this->expectException(PostNotFoundException::class);
        $this->expectExceptionMessage('Cannot get post: Good');

        $repository->getTextPost('Good');
    }

    public function testItSavePostToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid_post' =>'78a815b7-a3ed-a629-e845-920c0f5a034e',
                ':uuid_author'=>'cf6cdc15-b2f8-154d-7597-648a8294b64d',
                ':title'=>'Title1',
                ':text'=>'Good']);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostsRepository($connectionStub);

        $repository->savePost(new Post(
            new UUID('78a815b7-a3ed-a629-e845-920c0f5a034e'), 'cf6cdc15-b2f8-154d-7597-648a8294b64d','Title1','Good'
        ));
    }

    public function testItUUidPosts():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostsRepository($connectionStub);

        $this->expectException(PostNotFoundException::class);


        $repository->getByUuidPost('b0b10650-eb52-43a8-5a1c-cf167beed5d0');
    }
}