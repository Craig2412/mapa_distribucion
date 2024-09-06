<?php

namespace App\Action\Imagenes;

use App\Domain\Imagenes\Service\ImagenesDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImagenesDeleterAction
{
    private ImagenesDeleter $imagenesDeleter;

    private JsonRenderer $renderer;

    public function __construct(ImagenesDeleter $imagenesDeleter, JsonRenderer $renderer)
    {
        $this->imagenesDeleter = $imagenesDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $imagenesId = (int)$args['imagenes_id'];

        // Invoke the domain (service class)
        $this->imagenesDeleter->deleteImagenes($imagenesId);

        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
