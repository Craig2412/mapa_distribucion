<?php

namespace App\Action\Estatus;

use App\Domain\Estatus\Service\EstatusCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EstatusCreatorAction
{
    private JsonRenderer $renderer;

    private EstatusCreator $estatusCreator;

    public function __construct(EstatusCreator $estatusCreator, JsonRenderer $renderer)
    {
        $this->estatusCreator = $estatusCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $estatusId = $this->estatusCreator->createEstatus($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['estatus_id' => $estatusId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
