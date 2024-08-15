<?php

namespace App\Action\RepresentanteLegal;

use App\Domain\RepresentanteLegal\Data\RepresentanteLegalFinderResult;
use App\Domain\RepresentanteLegal\Service\RepresentanteLegalFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RepresentanteLegalFinderAction
{
    private RepresentanteLegalFinder $representanteLegalFinder;

    private JsonRenderer $renderer;

    public function __construct(RepresentanteLegalFinder $representanteLegalFinder, JsonRenderer $jsonRenderer)
    {
        $this->representanteLegalFinder = $representanteLegalFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $representanteLegals = $this->representanteLegalFinder->findRepresentanteLegals();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($representanteLegals));
    }

    public function transform(RepresentanteLegalFinderResult $result): array
    {
        $representanteLegals = [];

        foreach ($result->representanteLegals as $representanteLegal) {
            $representanteLegals[] = [
                'id' => $representanteLegal->id,
                'nombres' => $representanteLegal->nombres,
                'apellidos' => $representanteLegal->apellidos,
                'identificacion' => $representanteLegal->identificacion,
                'telefono' => $representanteLegal->telefono,
                'correo' => $representanteLegal->correo
            ];
        }

        return [
            'representanteLegals' => $representanteLegals,
        ];
    }
}
