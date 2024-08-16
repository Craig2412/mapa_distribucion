<?php

namespace App\Action\Estados;

use App\Domain\Estados\Data\EstadosReaderResult;
use App\Domain\Estados\Service\EstadosReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EstadosReaderAction
{
    private EstadosReader $estadosReader;

    private JsonRenderer $renderer;

    public function __construct(EstadosReader $estadosReader, JsonRenderer $jsonRenderer)
    {
        $this->estadosReader = $estadosReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $estadosId = (int)$args['estados_id'];

        // Invoke the domain and get the result
        $estados = $this->estadosReader->getEstados($estadosId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($estados));
    }

    private function transform(EstadosReaderResult $estados): array
    {
        return [
            'id' => $estados->id,
            'estado' => $estados->estado
        ];
    }
}
