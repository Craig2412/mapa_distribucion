<?php

namespace App\Action\RepresentanteLegal;

use App\Domain\RepresentanteLegal\Data\RepresentanteLegalReaderResult;
use App\Domain\RepresentanteLegal\Service\RepresentanteLegalbyCedulaReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RepresentanteLegalbyCedulaReaderAction
{
    private RepresentanteLegalbyCedulaReader $representanteLegalbyCedulaReader;

    private JsonRenderer $renderer;

    public function __construct(RepresentanteLegalbyCedulaReader $representanteLegalbyCedulaReader, JsonRenderer $jsonRenderer)
    {
        $this->representanteLegalbyCedulaReader = $representanteLegalbyCedulaReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $representanteLegalbyCedulaId = (string)$args['representanteLegal_cedula'];

        // Invoke the domain and get the result
        $representanteLegalbyCedula = $this->representanteLegalbyCedulaReader->getRepresentanteLegalbyCedula($representanteLegalbyCedulaId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($representanteLegalbyCedula));
    }

    private function transform(RepresentanteLegalReaderResult $representanteLegalbyCedula): array
    {
        return [
            'id' => $representanteLegalbyCedula->id,
            'nombres' => $representanteLegalbyCedula->nombres,
            'apellidos' => $representanteLegalbyCedula->apellidos,
            'identificacion' => $representanteLegalbyCedula->identificacion,
            'telefono' => $representanteLegalbyCedula->telefono,
            'correo' => $representanteLegalbyCedula->correo
        ];
    }
}
