<?php

namespace App\Action\Imagenes;

use App\Domain\Imagenes\Data\ImagenesReaderResult;
use App\Domain\Imagenes\Data\ImagenesFinderResult;
use App\Domain\Imagenes\Service\ImagenesReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImagenesReaderAction
{
    private ImagenesReader $imagenesReader;

    private JsonRenderer $renderer;

    public function __construct(ImagenesReader $imagenesReader, JsonRenderer $jsonRenderer)
    {
        $this->imagenesReader = $imagenesReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $imagenesId = (int)$args['id_mayorista'];

        // Invoke the domain and get the result
        $imagenes = $this->imagenesReader->getImagenes($imagenesId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($imagenes));
    }

    public function transform(ImagenesFinderResult $result): array
    {
        $imageness = [];

        foreach ($result->imageness as $imagenes) {
            $imageness[] = [
                'id' => $imagenes->id,
                'id_img' => $imagenes->id_img,
                'url' => $imagenes->url
            ];
        }

        return [
            'imageness' => $imageness,
        ];
    }
}
