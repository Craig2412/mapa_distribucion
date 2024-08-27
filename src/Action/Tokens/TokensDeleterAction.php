<?php

namespace App\Action\Tokens;

use App\Domain\Tokens\Service\TokensDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TokensDeleterAction
{
    private TokensDeleter $tokensDeleter;

    private JsonRenderer $renderer;

    public function __construct(TokensDeleter $tokensDeleter, JsonRenderer $renderer)
    {
        $this->tokensDeleter = $tokensDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $tokensId = (int)$args['token_id'];

        // Invoke the domain (service class)
        $this->tokensDeleter->deleteTokens($tokensId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
