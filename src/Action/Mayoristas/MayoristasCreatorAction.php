<?php

namespace App\Action\Mayoristas;

use App\Domain\Mayoristas\Service\MayoristasCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MayoristasCreatorAction
{
    private JsonRenderer $renderer;

    private MayoristasCreator $mayoristasCreator;

    public function __construct(MayoristasCreator $mayoristasCreator, JsonRenderer $renderer)
    {
        $this->mayoristasCreator = $mayoristasCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();
        // Invoke the Domain with inputs and retain the result
        $mayoristasId = $this->mayoristasCreator->createMayoristas($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['mayoristas_id' => $mayoristasId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
