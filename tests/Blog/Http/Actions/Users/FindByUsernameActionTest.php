<?php

namespace tgu\puzyrevskaya\PhpUnit\Blog\Http\Actions\Users;

use PHPUnit\Framework\TestCase;
use tgu\puzyrevskaya\Blog\Http\Actions\Users\FindByUsername;
use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\SuccessResponse;
use tgu\puzyrevskaya\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use tgu\puzyrevskaya\Blog\User;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\UserNotFoundException;
use tgu\puzyrevskaya\Person\Name;

class FindByUsernameActionTest extends TestCase
{
    private function userRepository(array $users):UsersRepositoryInterface{
        return new class($users) implements UsersRepositoryInterface{
            public function __construct(
                private array $users
            )
            {
            }

            public function save(User $user): void
            {
            }

            public function getByUsername(string $username): User
            {
                foreach ($this->users as $user){
                    if($user instanceof User && $username===$user->getUserName()){
                        return $user;
                    }
                }
                throw new UserNotFoundException('Not found');
            }

            public function getByUuid(UUID $uuid): User
            {
                throw new UserNotFoundException('Not found');
            }
        };
    }


    /**
     * @throws \JsonException
     */
    public function testItReturnErrorResponceIdNoUsernameProvided(): void
    {
        $request = new Request([], [], '');
        $userRepository = $this->userRepository([]);
        $action = new FindByUsername($userRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $responce);
        $this->expectOutputString('{"success":false,"reason":"No such query param in the request username"}');
        $responce->send();
    }


    /**
     * @throws \JsonException
     */
    public function testItReturnErrorResponceIdUserNotFound(): void{
        $request = new Request(['username'=>'Eugene'], [], '');
        $userRepository = $this->userRepository([]);
        $action = new FindByUsername($userRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $responce);
        $this->expectOutputString('{"success":false,"reason":"Not found"}');
        $responce->send();
    }

    /**
     * @throws \JsonException
     */
    public function testItReturnSuccessfulResponse(): void{
        $request = new Request(['username'=>'sia'], [],'');
        $userRepository = $this->userRepository([new User(UUID::random(),new Name('Eugene','Tikko'),'admin')]);
        $action = new FindByUsername($userRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(SuccessResponse::class, $responce);
        $this->expectOutputString('{"success":true,"data":{"username":"admin","name":"Eugene Tikko"}}');
        $responce->send();
    }
}