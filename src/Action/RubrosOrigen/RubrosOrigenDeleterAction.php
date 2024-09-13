<?php

namespace App\Action\RubrosOrigen;

use App\Domain\RubrosOrigen\Service\RubrosOrigenDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RubrosOrigenDeleterAction
{
    private RubrosOrigenDeleter $rubrosOrigenDeleter;

    private JsonRenderer $renderer;

    public function __construct(RubrosOrigenDeleter $rubrosOrigenDeleter, JsonRenderer $renderer)
    {
        $this->rubrosOrigenDeleter = $rubrosOrigenDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $rubrosOrigenId = (int)$args['rubrosOrigen_id'];

        // Invoke the domain (service class)
        $this->rubrosOrigenDeleter->deleteRubrosOrigen($rubrosOrigenId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
