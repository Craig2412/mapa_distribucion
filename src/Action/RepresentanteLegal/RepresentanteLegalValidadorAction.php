<?php

namespace App\Action\RepresentanteLegal;

use App\Domain\RepresentanteLegal\Service\RepresentanteLegalValidator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RepresentanteLegalValidadorAction
{
    private JsonRenderer $renderer;

    private RepresentanteLegalValidator $representanteLegalValidator;

    public function __construct(RepresentanteLegalValidator $representanteLegalValidator, JsonRenderer $renderer)
    {
        $this->representanteLegalValidator = $representanteLegalValidator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $representanteLegalId = $this->representanteLegalValidator->validateRepresentanteLegal($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['estatus' => true])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
