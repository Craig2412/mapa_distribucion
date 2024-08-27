<?php

namespace App\Action\Bufete;

use App\Domain\Bufete\Service\BufeteCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BufeteCreatorAction
{
    private JsonRenderer $renderer;

    private BufeteCreator $bufeteCreator;

    public function __construct(BufeteCreator $bufeteCreator, JsonRenderer $renderer)
    {
        $this->bufeteCreator = $bufeteCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $bufeteId = $this->bufeteCreator->createBufete($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['id' => $bufeteId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
