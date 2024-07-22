<?php

namespace App\Action\Auth;

use App\Domain\User\Service\UserCreator;
use App\Domain\Token\Service\TokenCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AuthSigninAction
{
    private JsonRenderer $renderer;

    private UserCreator $userCreator;

    private TokenCreator $tokenCreator;

    public function __construct(UserCreator $userCreator, TokenCreator $tokenCreator, JsonRenderer $renderer)
    {
        $this->userCreator = $userCreator;
        $this->tokenCreator = $tokenCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();
        // Invoke the Domain with inputs and retain the result
        $user = $this->userCreator->createUser($data);
        $token = $this->tokenCreator->createToken(["id"=>$user["id"], "id_role"=>$user["id_role"]]);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['user_data' => $user['id'], 'token' => $token['token']])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
