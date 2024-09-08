<?php

namespace App\Action\Bufete;

use App\Domain\Bufete\Service\BufeteUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BufeteUpdaterAction
{
    private BufeteUpdater $bufetesUpdater;

    private JsonRenderer $renderer;

    public function __construct(BufeteUpdater $bufetesUpdater, JsonRenderer $jsonRenderer)
    {
        $this->bufetesUpdater = $bufetesUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $bufetesId = (int)$args['id_bufete'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_date = $this->bufetesUpdater->updateBufete($bufetesId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datosNuevos' => $new_date]);
    }
}
