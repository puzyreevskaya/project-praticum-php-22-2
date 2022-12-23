<?php

namespace tgu\puzyrevskaya\Blog;

use tgu\puzyrevskaya\Person\Name;

class User
{
    private UUID $uuid;
    private Name $name;
    private string $username;

    public function __construct(UUID $uuid, Name $name, string $username)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
    }

    public function __toString(): string
    {
        $uuid=$this->getUuid();
        $firstname = $this->name->getFirstName();
        $lastname = $this->name->getLastName();
        return "Имя: $firstname $lastname логин $this->username ".PHP_EOL;
    }

    public function getUuid():UUID{
        return $this->uuid;
    }

    public function getName():Name{
        return $this->name;
    }

    public function getUserName():string{
        return $this->username;
    }

    public function gethashPassword():string{
        return $this->hashPassword;
    }

    public static function hash(string $password, UUID $uuid):string{
        return hash('sha256', $uuid . $password);
    }

    public function checkPassword(string $password):bool{
        return $this->hashPassword ===self::hash($password, $this->uuid);
    }

    public static function createFrom(
        string $username,
        string $password,
        Name $name,
    ): self
    {
        $uuid = UUID::random();
        return new self(
            $uuid,
            $name,
            $username,
            self::hash($password, $uuid),
        );
    }
}