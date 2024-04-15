<?php

namespace App\Action\Estatus;

use App\Domain\Estatus\Data\EstatusFinderResult;
use App\Domain\Estatus\Service\EstatusFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EstatusFinderAction
{
    private EstatusFinder $estatusFinder;

    private JsonRenderer $renderer;

    public function __construct(EstatusFinder $estatusFinder, JsonRenderer $jsonRenderer)
    {
        $this->estatusFinder = $estatusFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $estatuss = $this->estatusFinder->findEstatuss();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($estatuss));
    }

    public function transform(EstatusFinderResult $result): array
    {
        $estatuss = [];

        foreach ($result->estatuss as $estatus) {
            $estatuss[] = [
                'id' => $estatus->id,
                'estatus' => $estatus->estatus
            ];
        }

        return [
            'estatuss' => $estatuss,
        ];
    }
}
