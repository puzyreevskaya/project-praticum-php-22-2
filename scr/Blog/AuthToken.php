<?php

namespace tgu\puzyrevskaya\Blog;

class AuthToken
{
public function __construct(
    private string $token,
    private UUID $useruuid,
    private \DateTimeImmutable $expiresOn,

)
{
}

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return UUID
     */
    public function getUseruuid(): UUID
    {
        return $this->useruuid;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getExpiresOn(): \DateTimeImmutable
    {
        return $this->expiresOn;
    }

    public function __toString(): string
    {
        return $this->token;
    }
}