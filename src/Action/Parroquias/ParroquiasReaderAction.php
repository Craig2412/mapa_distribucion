<?php

namespace App\Action\Parroquias;

use App\Domain\Parroquias\Data\ParroquiasReaderResult;
use App\Domain\Parroquias\Service\ParroquiasReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ParroquiasReaderAction
{
    private ParroquiasReader $parroquiasReader;

    private JsonRenderer $renderer;

    public function __construct(ParroquiasReader $parroquiasReader, JsonRenderer $jsonRenderer)
    {
        $this->parroquiasReader = $parroquiasReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $parroquiasId = (int)$args['parroquias_id'];

        // Invoke the domain and get the result
        $parroquias = $this->parroquiasReader->getParroquias($parroquiasId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($parroquias));
    }

    private function transform(ParroquiasReaderResult $parroquias): array
    {
        return [
            'id' => $parroquias->id,
            'parroquia' => $parroquias->parroquia
        ];
    }
}
