<?php

namespace App\Action\Imagenes;

use App\Domain\Imagenes\Service\ImagenesCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImagenesCreatorAction
{
    private JsonRenderer $renderer;

    private ImagenesCreator $imagenesCreator;

    public function __construct(ImagenesCreator $imagenesCreator, JsonRenderer $renderer)
    {
        $this->imagenesCreator = $imagenesCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $data["precio_ptr"] = str_replace("," , "." , $data["precio_ptr"]);
        $imagenesId = $this->imagenesCreator->createImagenes($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['imagenes_id' => $imagenesId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
/*
{
    "url" : "Aceite",
    "id_mayorista" : 1 
}
*/