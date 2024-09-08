<?php

namespace App\Action\Bufete;

use App\Domain\Bufete\Service\BufeteDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BufeteDeleterAction
{
    private BufeteDeleter $bufeteDeleter;

    private JsonRenderer $renderer;

    public function __construct(BufeteDeleter $bufeteDeleter, JsonRenderer $renderer)
    {
        $this->bufeteDeleter = $bufeteDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $bufeteId = (int)$args['id_bufete'];
        // Invoke the domain (service class)
        $this->bufeteDeleter->deleteBufete($bufeteId);
        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
