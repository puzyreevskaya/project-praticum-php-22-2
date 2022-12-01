<?php

namespace tgu\puzyrevskaya\Person;

class Person
{
    public $id;
    public $name;
    public $lastname;

    public function __construct($id, $name, $lastname)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lastname = $lastname;
    }
}

?>