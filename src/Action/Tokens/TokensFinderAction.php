<?php

namespace App\Action\Tokens;

use App\Domain\Tokens\Data\TokensFinderResult;
use App\Domain\Tokens\Service\TokensFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TokensFinderAction
{
    private TokensFinder $tokensFinder;

    private JsonRenderer $renderer;

    public function __construct(TokensFinder $tokensFinder, JsonRenderer $jsonRenderer)
    {
        $this->tokensFinder = $tokensFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $tokenss = $this->tokensFinder->findTokenss();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($tokenss));
    }

    public function transform(TokensFinderResult $result): array
    {
        $tokenss = [];
        
        foreach ($result->tokenss as $tokens) {
            $tokenss[] = [
                'id' => $tokens->id,
                'token' => $tokens->token
            ];
        }

        return [
            'tokenss' => $tokenss,
        ];
    }
}
