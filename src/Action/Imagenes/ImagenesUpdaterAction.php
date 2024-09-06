<?php

namespace App\Action\Imagenes;

use App\Domain\Imagenes\Service\ImagenesUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImagenesUpdaterAction
{
    private ImagenesUpdater $imagenesUpdater;

    private JsonRenderer $renderer;

    public function __construct(ImagenesUpdater $imagenesUpdater, JsonRenderer $jsonRenderer)
    {
        $this->imagenesUpdater = $imagenesUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $imagenesId = (int)$args['imagenes_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_data = $this->imagenesUpdater->updateImagenes($imagenesId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['Datos nuevos' => $new_data]);
    }
}
