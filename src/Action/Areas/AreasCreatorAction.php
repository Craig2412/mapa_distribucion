<?php

namespace App\Action\Areas;

use App\Domain\Areas\Service\AreasCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreasCreatorAction
{
    private JsonRenderer $renderer;

    private AreasCreator $areasCreator;

    public function __construct(AreasCreator $areasCreator, JsonRenderer $renderer)
    {
        $this->areasCreator = $areasCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $areasId = $this->areasCreator->createAreas($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['areas_id' => $areasId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
