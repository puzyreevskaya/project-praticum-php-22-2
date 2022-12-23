<?php

namespace tgu\puzyrevskaya\PhpUnit\Blog\Http\Actions\Posts;

use PHPUnit\Framework\TestCase;
use tgu\puzyrevskaya\Blog\Http\Actions\Posts\CreatePosts;
use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\SuccessResponse;
use tgu\puzyrevskaya\Blog\Post;
use tgu\puzyrevskaya\Blog\Repositories\PostRepositories\PostsRepositoryInterface;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\PostNotFoundException;

class CreatePostActionTest extends TestCase
{
    private function postRepository(array $posts):PostsRepositoryInterface{
        return new class($posts) implements PostsRepositoryInterface {
            public function __construct(
                public array $array
            )
            {
            }

            public function savePost(Post $post): void
            {
                // TODO: Implement save() method.
            }

            public function getByUuidPost(UUID $uuid): Post
            {
                throw new PostNotFoundException('Not found');
            }
            
            public function getTextPost(string $text): Post
            {
                // TODO: Implement getTextPost() method.
            }
        };
    }


    public function testItReturnErrorResponceIfNoUuid(): void
    {
        $request = new Request([], [], '');
        $postRepository = $this->postRepository([]);
        $action = new CreatePosts($postRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $responce);
        $this->expectOutputString('{"success":false,"reason":"No such query param in the request uuid_post"}');
        $responce->send();
    }


    public function testItReturnErrorResponceIfUUIDNotFound(): void{
        $uuid = UUID::random();
        $request = new Request(['uuid_post'=>$uuid], [], '');
        $userRepository = $this->postRepository([]);
        $action = new CreatePosts($userRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $responce);
        $this->expectOutputString('{"success":false,"reason":"Not found"}');
        $responce->send();
    }

    /**
     * @throws \JsonException
     */
    public function testItReturnSuccessfulResponse(): void{
        $uuid = UUID::random();
        $request = new Request(['uuid_post'=>"$uuid"], [],'');
        $postRepository = $this->postRepository([new Post($uuid,'d34cd6a4-44a5-3d65-52bb-e3efcb390a0c','Title1','Title1')]);
        $action = new CreatePosts($postRepository);
        $responce = $action->handle($request);
        var_dump($responce);
        $this->assertInstanceOf(SuccessResponse::class, $responce);
        $this->expectOutputString('{"success":true,"data":{"uuid_post":"Eugene"}}');
        $responce->send();
    }
}