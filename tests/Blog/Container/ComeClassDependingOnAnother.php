<?php

namespace tgu\puzyrevskaya\PhpUnit\Blog\Container;

class ComeClassDependingOnAnother
{
    public function __construct(
        SomeClassWithoutDependencies $one,
        SomeClassWithParameter $two
    )
    {

    }
}