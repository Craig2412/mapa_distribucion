<?php

namespace App\Action\Areas;

use App\Domain\Areas\Service\AreasUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreasUpdaterAction
{
    private AreasUpdater $areasUpdater;

    private JsonRenderer $renderer;

    public function __construct(AreasUpdater $areasUpdater, JsonRenderer $jsonRenderer)
    {
        $this->areasUpdater = $areasUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $areasId = (int)$args['area_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_date = $this->areasUpdater->updateAreas($areasId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datosNuevos' => $new_date]);
    }
}
