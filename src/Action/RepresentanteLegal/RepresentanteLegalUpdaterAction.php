<?php

namespace App\Action\RepresentanteLegal;

use App\Domain\RepresentanteLegal\Service\RepresentanteLegalUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RepresentanteLegalUpdaterAction
{
    private RepresentanteLegalUpdater $representanteLegalUpdater;

    private JsonRenderer $renderer;

    public function __construct(RepresentanteLegalUpdater $representanteLegalUpdater, JsonRenderer $jsonRenderer)
    {
        $this->representanteLegalUpdater = $representanteLegalUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $representanteLegalId = (int)$args['representanteLegal_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->representanteLegalUpdater->updateRepresentanteLegal($representanteLegalId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
