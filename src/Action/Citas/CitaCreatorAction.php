<?php

namespace App\Action\Citas;

use App\Domain\Cita\Service\CitaCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Auth\Auth;

final class CitaCreatorAction
{
    private JsonRenderer $renderer;

    private CitaCreator $citasCreator;

    public function __construct(CitaCreator $citasCreator, JsonRenderer $renderer)
    {
        $this->citasCreator = $citasCreator;
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
        $citasId = $this->citasCreator->createCita($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['citas_id' => $citasId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
