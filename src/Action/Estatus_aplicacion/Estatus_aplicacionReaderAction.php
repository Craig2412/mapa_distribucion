<?php

namespace App\Action\Estatus_aplicacion;

use App\Domain\Estatus_aplicacion\Data\Estatus_aplicacionReaderResult;
use App\Domain\Estatus_aplicacion\Service\Estatus_aplicacionReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Estatus_aplicacionReaderAction
{
    private Estatus_aplicacionReader $estatus_aplicacionReader;

    private JsonRenderer $renderer;

    public function __construct(Estatus_aplicacionReader $estatus_aplicacionReader, JsonRenderer $jsonRenderer)
    {
        $this->estatus_aplicacionReader = $estatus_aplicacionReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $estatus_aplicacionId = (int)$args['estatus_aplicacion_id'];

        // Invoke the domain and get the result
        $estatus_aplicacion = $this->estatus_aplicacionReader->getEstatus_aplicacion($estatus_aplicacionId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($estatus_aplicacion));
    }

    private function transform(Estatus_aplicacionReaderResult $estatus_aplicacion): array
    {
        return [
            'id' => $estatus_aplicacion->id,
            'estatus_aplicacion' => $estatus_aplicacion->estatus_aplicacion
        ];
    }
}
