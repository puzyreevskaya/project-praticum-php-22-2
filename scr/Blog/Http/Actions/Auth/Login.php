<?php

namespace tgu\puzyrevskaya\Blog\Http\Actions\Auth;

use tgu\puzyrevskaya\Blog\AuthToken;
use tgu\puzyrevskaya\Blog\Http\Actions\ActionInterface;
use tgu\puzyrevskaya\Blog\Http\Auth\PasswordAuthenticationInterface;
use tgu\puzyrevskaya\Blog\Http\ErrorResponse;
use tgu\puzyrevskaya\Blog\Http\Request;
use tgu\puzyrevskaya\Blog\Http\Response;
use tgu\puzyrevskaya\Blog\Http\SuccessResponse;
use tgu\puzyrevskaya\Blog\Repositories\AuthTokenRepository\AuthTokenRepositoryInterface;
use tgu\puzyrevskaya\Exceptions\AuthException;

class Login implements ActionInterface
{
public function __construct(
    private PasswordAuthenticationInterface $passwordAuthentication,
    private AuthTokenRepositoryInterface $authTokenRepository,
    )
    {

    }
    public function handle(Request $request): Response
    {
        try {
            $user = $this->passwordAuthentication->user($request);
        }catch (AuthException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $authToken = new AuthToken(
            bin2hex(random_bytes(40)),
            $user->getUuid(),
            (new \DateTimeImmutable())->modify('+1 day')
        );
        $this->authTokenRepository->save($authToken);
        return new SuccessResponse([
            'token' =>(string)$authToken,
        ]);
    }
}