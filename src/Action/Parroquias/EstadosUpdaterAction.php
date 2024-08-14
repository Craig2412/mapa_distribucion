<?php

namespace App\Action\Rubros;

use App\Domain\Rubros\Service\RubrosUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RubrosUpdaterAction
{
    private RubrosUpdater $rubrosUpdater;

    private JsonRenderer $renderer;

    public function __construct(RubrosUpdater $rubrosUpdater, JsonRenderer $jsonRenderer)
    {
        $this->rubrosUpdater = $rubrosUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $rubrosId = (int)$args['rubros_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->rubrosUpdater->updateRubros($rubrosId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
