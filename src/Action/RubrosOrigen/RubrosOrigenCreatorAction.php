<?php

namespace App\Action\RubrosOrigen;

use App\Domain\RubrosOrigen\Service\RubrosOrigenCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RubrosOrigenCreatorAction
{
    private JsonRenderer $renderer;

    private RubrosOrigenCreator $rubrosOrigenCreator;

    public function __construct(RubrosOrigenCreator $rubrosOrigenCreator, JsonRenderer $renderer)
    {
        $this->rubrosOrigenCreator = $rubrosOrigenCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $data["precio_ptr"] = str_replace("," , "." , $data["precio_ptr"]);
        $rubrosOrigenId = $this->rubrosOrigenCreator->createRubrosOrigen($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['rubrosOrigen_id' => $rubrosOrigenId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
/*
{
    "rubro" : "Aceite",
    "presentacion" : "500ml",
    "precio_ves" : 500,
    "precio_ptr" : 0.00006
}
*/