<?php
namespace  tgu\puzyrevskaya\Person;

class Name {
    private string $firstname;
    private string $lastname;

    public function  __construct($firstname, $lastname)
    {
    }

    public function __toString(): string {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }
    public function getLastname(): string
    {
        return $this->lastname;
    }

}