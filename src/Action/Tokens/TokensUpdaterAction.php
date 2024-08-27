<?php

namespace App\Action\Tokens;

use App\Domain\Tokens\Service\TokensUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TokensUpdaterAction
{
    private TokensUpdater $tokensUpdater;

    private JsonRenderer $renderer;

    public function __construct(TokensUpdater $tokensUpdater, JsonRenderer $jsonRenderer)
    {
        $this->tokensUpdater = $tokensUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $tokensId = (int)$args['token_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->tokensUpdater->updateTokens($tokensId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datosNuevos' => $new_data]);
    }
}
