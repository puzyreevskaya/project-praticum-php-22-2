<?php
require_once __DIR__ . '/vendor/autoload.php';

function someFunction(bool $one, int $two=42,):string
{
    return $one . $two;
}

$reflection = new ReflectionFunction('someFunction');
echo $reflection->getReturnType()->getName()."\n";
foreach ($reflection->getParameters() as $parameter){
    echo $parameter->getName().'['.$parameter->getType()->getName()."]\n";
}
?>