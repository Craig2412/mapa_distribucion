<?php

namespace App\Action\Areas;

use App\Domain\Areas\Data\AreasReaderResult;
use App\Domain\Areas\Service\AreasReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreasReaderAction
{
    private AreasReader $areaReader;

    private JsonRenderer $renderer;

    public function __construct(AreasReader $areaReader, JsonRenderer $jsonRenderer)
    {
        $this->areaReader = $areaReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $areaId = (int)$args['area_id'];

        // Invoke the domain and get the result
        $area = $this->areaReader->getAreas($areaId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($area));
    }

    private function transform(AreasReaderResult $area): array
    {
        return [
            'id' => $area->id,
            'area' => $area->area
        ];
    }
}
