<?php

namespace tgu\puzyrevskaya\Blog;

class Comments
{
public function __construct(
    private UUID $idCom,
    private string $id_post,
    private string $id_author,
    private string $textCom
)
{

}
    public function __toString(): string
    {
        return $this->idCom . ' ' .$this->id_author . ' ' .$this->id_post . ' ' . $this->textCom;
    }
    public function getUuidComment():UUID{
        return $this->idCom;
    }
    public function getUuidPost():string{
        return $this->id_post;
    }
    public function getUuidUser():string{
        return $this->id_author;
    }
    public function getTextComment():string{
        return $this->textCom;
    }
}