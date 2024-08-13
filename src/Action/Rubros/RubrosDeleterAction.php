<?php

namespace App\Action\Rubros;

use App\Domain\Rubros\Service\RubrosDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RubrosDeleterAction
{
    private RubrosDeleter $rubrosDeleter;

    private JsonRenderer $renderer;

    public function __construct(RubrosDeleter $rubrosDeleter, JsonRenderer $renderer)
    {
        $this->rubrosDeleter = $rubrosDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $rubrosId = (int)$args['rubros_id'];

        // Invoke the domain (service class)
        $this->rubrosDeleter->deleteRubros($rubrosId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
