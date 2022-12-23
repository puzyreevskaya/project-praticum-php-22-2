<?php

namespace tgu\puzyrevskaya\Person;

class Person
{
    public function __construct(private Name $name, private DateTimeImmutable $registeredOn)
    {

    }

    public function __toString(): string
    {
      return $this->name . ' на сайте с ' . $this->registeredOn->format('Y-m-d');
    }

    public function getName(): Name{
        return $this->name;
    }

    public function getUserName(): Name{
        return $this->userName;
    }
}

?>