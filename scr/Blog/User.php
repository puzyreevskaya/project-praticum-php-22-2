<?php

namespace tgu\puzyrevskaya\Blog;

use tgu\puzyrevskaya\Person\Name;

class User
{
    private int $id;
    private Name $name;
    private string $username;

    public function __construct(int $id, Name $name, string $username)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
    }

    public function __toString(): string {
        $firstname = $this->name->getFirstName();
        $lastname = $this->name->getLastName();
        return "Имя: $firstname $lastname логин $this->username ".PHP_EOL;
    }
    public function getId(): int{
        return $this->id;
    }

    public function getName(): Name{
        return $this->name;
    }

    public function getUserName(): Name{
        return $this->userName;
    }
}
