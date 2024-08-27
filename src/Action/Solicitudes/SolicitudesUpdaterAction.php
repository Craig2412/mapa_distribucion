<?php

namespace App\Action\Solicitudes;

use App\Domain\Solicitudes\Service\SolicitudesUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SolicitudesUpdaterAction
{
    private SolicitudesUpdater $solicitudesUpdater;

    private JsonRenderer $renderer;

    public function __construct(SolicitudesUpdater $solicitudesUpdater, JsonRenderer $jsonRenderer)
    {
        $this->solicitudesUpdater = $solicitudesUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $solicitud,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the solicitud body
        $solicitudesId = (int)$args['id_solicitud'];
        $data = (array)$solicitud->getParsedBody();

        /* if ($data['id_estado'] != 7) {
            return $response->withStatus(406)
                            ->withHeader('Error', 'El status ingresado no es valido');
        }*/
        // Invoke the Domain with inputs and retain the result
        $new_date = $this->solicitudesUpdater->updateSolicitudes($solicitudesId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datosNuevos' => $new_date]);
    }
}
