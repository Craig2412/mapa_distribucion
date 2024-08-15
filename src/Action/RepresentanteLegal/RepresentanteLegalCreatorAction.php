<?php

namespace App\Action\RepresentanteLegal;

use App\Domain\RepresentanteLegal\Service\RepresentanteLegalCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RepresentanteLegalCreatorAction
{
    private JsonRenderer $renderer;

    private RepresentanteLegalCreator $representanteLegalCreator;

    public function __construct(RepresentanteLegalCreator $representanteLegalCreator, JsonRenderer $renderer)
    {
        $this->representanteLegalCreator = $representanteLegalCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $representanteLegalId = $this->representanteLegalCreator->createRepresentanteLegal($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['representanteLegal_id' => $representanteLegalId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
