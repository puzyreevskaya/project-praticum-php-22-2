<?php

namespace tgu\puzyrevskaya\Blog\Http;

abstract class Response
{
    protected const SUCCESS = true;
    /**
     * @throws \JsonException
     */
    public function send():void{
        $data = ['success'=>static::SUCCESS]+$this->payload();
        header('Content-Type:application/json');
        echo json_encode($data, JSON_THROW_ON_ERROR);
    }
    abstract function payload():array;
}