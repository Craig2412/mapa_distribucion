<?php

namespace App\Action\Tokens;

use App\Domain\Tokens\Service\TokensCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TokensCreatorAction
{
    private JsonRenderer $renderer;

    private TokensCreator $tokensCreator;

    public function __construct(TokensCreator $tokensCreator, JsonRenderer $renderer)
    {
        $this->tokensCreator = $tokensCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $tokensId = $this->tokensCreator->createTokens($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['token_id' => $tokensId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
