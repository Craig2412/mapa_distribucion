<?php

namespace App\Action\UsuariosAreas;

use App\Domain\UsuariosAreas\Data\UsuariosAreasReaderResult;
use App\Domain\UsuariosAreas\Service\UsuariosAreasReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuariosAreasReaderAction
{
    private UsuariosAreasReader $usuariosareaReader;

    private JsonRenderer $renderer;

    public function __construct(UsuariosAreasReader $usuariosareaReader, JsonRenderer $jsonRenderer)
    {
        $this->usuariosareaReader = $usuariosareaReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $usuariosareaId = (int)$args['usuarios_area_id'];

        // Invoke the domain and get the result
        $usuariosarea = $this->usuariosareaReader->getUsuariosAreas($usuariosareaId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($usuariosarea));
    }

    private function transform(UsuariosAreasReaderResult $usuariosarea): array
    {
        return [
                'id' => $usuariosarea->id,
                'id_usuario' => $usuariosarea->id_usuario,
                'nombre' => $usuariosarea->nombre,
                'id_area' => $usuariosarea->id_area,
                'area' => $usuariosarea->area
        ];
    }
}
