<?php

namespace App\Action\Solicitudes;

use App\Domain\Solicitudes\Service\SolicitudesCreator;
use App\Renderer\JsonRenderer;
use Cake\Database\Connection;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Auth\Auth;

final class SolicitudesCreatorAction
{
    private JsonRenderer $renderer;

    private SolicitudesCreator $solicitudesCreator;

    public function __construct(SolicitudesCreator $solicitudesCreator, JsonRenderer $renderer)
    {
        $this->solicitudesCreator = $solicitudesCreator;
        $this->renderer = $renderer;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $aud = Auth::Aud();
        if ($aud !== 'https://censoapi.sapi.gob.ve') {
            return $response->withStatus(401);
        }
        // Extract the form data from the request body
        $data = $request->getParsedBody();
        // Check connection
        
        // Invoke the Domain with inputs and retain the result
        $solicitudesId = $this->solicitudesCreator->createSolicitudes($data);
        
        // Build the HTTP response
        return $this->renderer
                    ->json($response, ['id_solicitudes' => $solicitudesId])
                    ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}


/*
[
    {
        
        "num_solicitud":1006004569,        
        "num_registro":"T510080",
        "id_requerimiento":1,
        "id_categoria":1,
        "descripcion": "Problema X"
    },
    {
        "num_solicitud":1008004569,        
        "num_registro":"T510080",
        "id_requerimiento":1,
        "id_categoria":1,
        "descripcion": "Problema X"
    }
]
 */