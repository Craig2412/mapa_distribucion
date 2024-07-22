<?php

namespace App\Action\Estatus;

use App\Domain\Estatus\Data\EstatusReaderResult;
use App\Domain\Estatus\Service\EstatusReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EstatusReaderAction
{
    private EstatusReader $estatusReader;

    private JsonRenderer $renderer;

    public function __construct(EstatusReader $estatusReader, JsonRenderer $jsonRenderer)
    {
        $this->estatusReader = $estatusReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $estatusId = (int)$args['estatus_id'];

        // Invoke the domain and get the result
        $estatus = $this->estatusReader->getEstatus($estatusId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($estatus));
    }

    private function transform(EstatusReaderResult $estatus): array
    {
        return [
            'id' => $estatus->id,
            'estatus' => $estatus->estatus
        ];
    }
}
