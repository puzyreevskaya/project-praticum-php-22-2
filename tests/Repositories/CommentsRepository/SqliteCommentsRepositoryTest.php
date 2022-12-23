<?php

namespace tgu\puzyrevskaya\PhpUnit\Repositories\CommentsRepository;

use http\Exception\InvalidArgumentException;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use tgu\puzyrevskaya\Blog\Comments;
use tgu\puzyrevskaya\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\CommentNotFoundException;
use tgu\puzyrevskaya\PhpUnit\Blog\DummyLogger;


class SqliteCommentsRepositoryTest extends TestCase
{
    public function testItTrowsAnExceptionWhenCommentNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot get comment: some_text');

        $repository->getTextComment('some_text');
    }

    public function testItSaveCommentsToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid_comment' =>'f165d492-bffe-448f-a499-b72d16a40f1b',
                ':uuid_post'=>'b0b10650-eb52-43a8-5a1c-cf167beed5d0',
                ':uuid_author'=>'cf6cdc15-b2f8-154d-7597-648a8294b64d',
                ':textCom'=>'some_text'
            ]);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $repository->saveComment( new Comments(
            new UUID('f165d492-bffe-448f-a499-b72d16a40f1b'), 'b0b10650-eb52-43a8-5a1c-cf167beed5d0','cf6cdc15-b2f8-154d-7597-648a8294b64d','Good'
            ));
    }

    public function testItUUidComments():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);


        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot get comment:f165d492-bffe-448f-a499-b72d16a40f1b');

         $repository->getByUuidComment('f165d492-bffe-448f-a499-b72d16a40f1b');
    }
}