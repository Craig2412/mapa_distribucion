<?php

namespace App\Action\Auth;

use App\Domain\User\Service\UserLogin;
use App\Domain\User\Data\UserLoginResult;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class AuthLoginAction
{
    private JsonRenderer $renderer;

    private UserLogin $userLogin;

    public function __construct(UserLogin $userLogin, JsonRenderer $renderer)
    {
        $this->userLogin = $userLogin;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
        ): ResponseInterface {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $user = $this->userLogin->loginUser($data);
        return $this->renderer->json($response, $this->transform($user));
    }

    private function transform(UserLoginResult $users): array
    {
        return [
            'id' => $users->id,
            'token' => $users->token
        ];
    }
    

    
}