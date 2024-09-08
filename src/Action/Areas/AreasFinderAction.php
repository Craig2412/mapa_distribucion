<?php

namespace App\Action\Areas;

use App\Domain\Areas\Data\AreasFinderResult;
use App\Domain\Areas\Service\AreasFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreasFinderAction
{
    private AreasFinder $AreasFinder;

    private JsonRenderer $renderer;

    public function __construct(AreasFinder $AreasFinder, JsonRenderer $jsonRenderer)
    {
        $this->areasFinder = $AreasFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $areas = $this->areasFinder->findareas();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($areas));
    }

    public function transform(AreasFinderResult $result): array
    {
        $areas = [];

        foreach ($result->areas as $areas) {
            $area[] = [
                'id' => $areas->id,
                'area' => $areas->area
            ]; 
        }

        return [
            'areas' => $area,
        ];
    }
}
