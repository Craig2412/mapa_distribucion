<?php

namespace App\Action\Rubros;

use App\Domain\Rubros\Service\RubrosCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RubrosCreatorAction
{
    private JsonRenderer $renderer;

    private RubrosCreator $rubrosCreator;

    public function __construct(RubrosCreator $rubrosCreator, JsonRenderer $renderer)
    {
        $this->rubrosCreator = $rubrosCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $rubrosId = $this->rubrosCreator->createRubros($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['rubros_id' => $rubrosId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
