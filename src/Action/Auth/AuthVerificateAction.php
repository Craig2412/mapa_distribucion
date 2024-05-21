<?php

namespace App\Action\Auth;

use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AuthVerificateAction
{
    private JsonRenderer $renderer;

    public function __construct( JsonRenderer $renderer)
    {
        
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Build the HTTP response
        return $this->renderer->json($response, true);
    }
}
