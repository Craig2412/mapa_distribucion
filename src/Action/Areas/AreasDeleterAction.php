<?php

namespace App\Action\Areas;

use App\Domain\Areas\Service\AreasDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreasDeleterAction
{
    private AreasDeleter $areasDeleter;

    private JsonRenderer $renderer;

    public function __construct(AreasDeleter $areasDeleter, JsonRenderer $renderer)
    {
        $this->areasDeleter = $areasDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $areasId = (int)$args['area_id'];
        // Invoke the domain (service class)
        $this->areasDeleter->deleteAreas($areasId);
        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
