<?php

namespace App\Action\Estatus;

use App\Domain\Estatus\Service\EstatusUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EstatusUpdaterAction
{
    private EstatusUpdater $estatusUpdater;

    private JsonRenderer $renderer;

    public function __construct(EstatusUpdater $estatusUpdater, JsonRenderer $jsonRenderer)
    {
        $this->estatusUpdater = $estatusUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $estatusId = (int)$args['estatus_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->estatusUpdater->updateEstatus($estatusId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
