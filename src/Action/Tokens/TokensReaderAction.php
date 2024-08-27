<?php

namespace App\Action\Tokens;

use App\Domain\Tokens\Data\TokensReaderResult;
use App\Domain\Tokens\Service\TokensReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TokensReaderAction
{
    private TokensReader $tokensReader;

    private JsonRenderer $renderer;

    public function __construct(TokensReader $tokensReader, JsonRenderer $jsonRenderer)
    {
        $this->tokensReader = $tokensReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $tokensId = (int)$args['token_id'];

        // Invoke the domain and get the result
        $tokens = $this->tokensReader->getTokens($tokensId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($tokens));
    }

    private function transform(TokensReaderResult $tokens): array
    {
        return [
            'id' => $tokens->id,
            'token' => $tokens->token           
        ];
    }
}
