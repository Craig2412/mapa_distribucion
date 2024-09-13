<?php

namespace App\Action\RubrosOrigen;

use App\Domain\RubrosOrigen\Service\RubrosOrigenUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RubrosOrigenUpdaterAction
{
    private RubrosOrigenUpdater $rubrosOrigenUpdater;

    private JsonRenderer $renderer;

    public function __construct(RubrosOrigenUpdater $rubrosOrigenUpdater, JsonRenderer $jsonRenderer)
    {
        $this->rubrosOrigenUpdater = $rubrosOrigenUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $rubrosOrigenId = (int)$args['rubrosOrigen_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->rubrosOrigenUpdater->updateRubrosOrigen($rubrosOrigenId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
