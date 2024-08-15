<?php

namespace App\Action\RepresentanteLegal;

use App\Domain\RepresentanteLegal\Data\RepresentanteLegalReaderResult;
use App\Domain\RepresentanteLegal\Service\RepresentanteLegalReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RepresentanteLegalReaderAction
{
    private RepresentanteLegalReader $representanteLegalReader;

    private JsonRenderer $renderer;

    public function __construct(RepresentanteLegalReader $representanteLegalReader, JsonRenderer $jsonRenderer)
    {
        $this->representanteLegalReader = $representanteLegalReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $representanteLegalId = (int)$args['representanteLegal_id'];

        // Invoke the domain and get the result
        $representanteLegal = $this->representanteLegalReader->getRepresentanteLegal($representanteLegalId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($representanteLegal));
    }

    private function transform(RepresentanteLegalReaderResult $representanteLegal): array
    {
        return [
            'id' => $representanteLegal->id,
            'nombres' => $representanteLegal->nombres,
            'apellidos' => $representanteLegal->apellidos,
            'identificacion' => $representanteLegal->identificacion,
            'telefono' => $representanteLegal->telefono,
            'correo' => $representanteLegal->correo
        ];
    }
}
