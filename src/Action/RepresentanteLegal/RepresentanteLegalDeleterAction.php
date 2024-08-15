<?php

namespace App\Action\RepresentanteLegal;

use App\Domain\RepresentanteLegal\Service\RepresentanteLegalDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RepresentanteLegalDeleterAction
{
    private RepresentanteLegalDeleter $representanteLegalDeleter;

    private JsonRenderer $renderer;

    public function __construct(RepresentanteLegalDeleter $representanteLegalDeleter, JsonRenderer $renderer)
    {
        $this->representanteLegalDeleter = $representanteLegalDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $representanteLegalId = (int)$args['representanteLegal_id'];

        // Invoke the domain (service class)
        $this->representanteLegalDeleter->deleteRepresentanteLegal($representanteLegalId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
