<?php

namespace App\Action\Parroquias;

use App\Domain\Parroquias\Data\ParroquiasFinderResult;
use App\Domain\Parroquias\Service\ParroquiasFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ParroquiasFinderAction
{
    private ParroquiasFinder $parroquiasFinder;

    private JsonRenderer $renderer;

    public function __construct(ParroquiasFinder $parroquiasFinder, JsonRenderer $jsonRenderer)
    {
        $this->parroquiasFinder = $parroquiasFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...
        $municipioId = (int)$args['municipio_id'];

        $parroquiass = $this->parroquiasFinder->findParroquiass($municipioId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($parroquiass));
    }

    public function transform(ParroquiasFinderResult $result): array
    {
        $parroquiass = [];

        foreach ($result->parroquiass as $parroquias) {
            $parroquiass[] = [
                'id' => $parroquias->id,
                'parroquia' => $parroquias->parroquia
            ];
        }

        return [
            'parroquiass' => $parroquiass,
        ];
    }
}
