<?php

namespace App\Action\Imagenes;

use App\Domain\Imagenes\Data\ImagenesFinderResult;
use App\Domain\Imagenes\Service\ImagenesFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImagenesFinderAction
{
    private ImagenesFinder $imagenesFinder;

    private JsonRenderer $renderer;

    public function __construct(ImagenesFinder $imagenesFinder, JsonRenderer $jsonRenderer)
    {
        $this->imagenesFinder = $imagenesFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $imageness = $this->imagenesFinder->findImageness();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($imageness));
    }

    public function transform(ImagenesFinderResult $result): array
    {
        $imageness = [];

        foreach ($result->imageness as $imagenes) {
            $imageness[] = [
                'id' => $imagenes->id,
                'url' => $imagenes->url
            ];
        }

        return [
            'imageness' => $imageness,
        ];
    }
}
