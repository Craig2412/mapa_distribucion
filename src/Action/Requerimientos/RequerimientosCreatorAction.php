<?php

namespace App\Action\Requerimientos;

use App\Domain\Requerimientos\Service\RequerimientosCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Auth\Auth;

final class RequerimientosCreatorAction
{
    private JsonRenderer $renderer;

    private RequerimientosCreator $requerimientosCreator;

    public function __construct(RequerimientosCreator $requerimientosCreator, JsonRenderer $renderer)
    {
        $this->requerimientosCreator = $requerimientosCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $aud = Auth::Aud();
        if ($aud !== 'https://censoapi.sapi.gob.ve') {
            return $response->withStatus(401);
        }
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $requerimientosId = $this->requerimientosCreator->createRequerimientos($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['requerimientos_id' => $requerimientosId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
