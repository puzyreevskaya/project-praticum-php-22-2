<?php

namespace tgu\puzyrevskaya\PhpUnit\Repositories\UserRepository;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use tgu\puzyrevskaya\Blog\Repositories\UserRepository\SqliteUsersRepository;
use tgu\puzyrevskaya\Blog\User;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\InvalidArgumentExceptions;
use tgu\puzyrevskaya\Exceptions\UserNotFoundException;
use tgu\puzyrevskaya\Person\Name;

class SqliteUsersRepositoryTest extends TestCase
{
 public function testItTrowsAnExceptionWhenUserNotFound():void
 {
     $connectionStub = $this->createStub(PDO::class);
     $statementStub =  $this->createStub(PDOStatement::class);

     $statementStub->method('fetch')->willReturn(false);
     $connectionStub->method('prepare')->willReturn($statementStub);

     $repository = new SqliteUsersRepository($connectionStub);

     $this->expectException(UserNotFoundException::class);
     $this->expectExceptionMessage('Cannot get user: admin');

     $repository->getByUsername('admin');
 }

    public function testItSaveUserToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':first_name'=>'Eugene',
                ':last_name'=>'Tikko',
                ':uuid' =>'d34cd6a4-44a5-3d65-52bb-e3efcb390a0c',
                ':username'=>'admin'
            ]);
          $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub);

        $repository->save(new User(
            new UUID('d34cd6a4-44a5-3d65-52bb-e3efcb390a0c'),
            new Name('Eugene', 'Tikko'), 'admin'
        ));
    }

    /**
     * @throws UserNotFoundException
     */
    public function testItUUidUser ():User
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub);
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage(' UUID: d34cd6a4-44a5-3d65-52bb-e3efcb390a0c');

        $repository->getByUuid('d34cd6a4-44a5-3d65-52bb-e3efcb390a0c');
    }

}