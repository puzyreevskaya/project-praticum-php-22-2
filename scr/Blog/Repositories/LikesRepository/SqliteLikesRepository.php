<?php

namespace tgu\puzyrevskaya\Blog\Repositories\LikesRepository;

use PDO;
use PDOStatement;
use tgu\puzyrevskaya\Blog\Likes;
use tgu\puzyrevskaya\Blog\UUID;
use tgu\puzyrevskaya\Exceptions\LikeNotFoundException;

class SqliteLikesRepository implements LikesRepositoryInterface
{
    public function __construct(private PDO $connection)
    {

    }

    public function saveLike(Likes $likes):void{
        $statement = $this->connection->prepare(
            "INSERT INTO likes (uuid_like, uuid_post, uuid_user) VALUES (:uuid_like,:uuid_post,:uuid_user)");
        $statement->execute([
            ':uuid_comment'=>(string)$likes->getUuidLike(),
            ':uuid_post'=>$likes->getUuidPost(),
            ':uuid_author'=>$likes->getUuidUser()]);
    }


    /**
     * @throws LikeNotFoundException
     */
    private function getLike(PDOStatement $statement, string $value):Likes{
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result===false){
            throw new LikeNotFoundException("Cannot get like: $value");
        }
        return new Likes(new UUID($result['uuid_like']), $result['uuid_post'], $result['uuid_user']);
    }


    /**
     * @throws LikeNotFoundException
     */
    public function getByPostUuid(string $uuid_post): Likes
    {
        $statement = $this->connection->prepare(
            "SELECT * FROM likes WHERE uuid_post = :uuid_post"
        );
        $statement->execute([':uuid_post'=>$uuid_post]);
        return $this->getLike($statement, $uuid_post);
    }
}