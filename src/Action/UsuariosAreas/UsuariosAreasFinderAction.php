<?php

namespace App\Action\UsuariosAreas;

use App\Domain\UsuariosAreas\Data\UsuariosAreasFinderResult;
use App\Domain\UsuariosAreas\Service\UsuariosAreasFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuariosAreasFinderAction
{
    private UsuariosAreasFinder $UsuariosAreasFinder;

    private JsonRenderer $renderer;

    public function __construct(UsuariosAreasFinder $UsuariosAreasFinder, JsonRenderer $jsonRenderer)
    {
        $this->usuariosareasFinder = $UsuariosAreasFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $usuariosareas = $this->usuariosareasFinder->findusuariosareas();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($usuariosareas));
    }

    public function transform(UsuariosAreasFinderResult $result): array
    {
        $usuariosareas = [];

        foreach ($result->usuariosareas as $usuariosareas) {
            $usuariosarea[] = [
                'id' => $usuariosareas->id,
                'id_usuario' => $usuariosareas->id_usuario,
                'nombre' => $usuariosareas->nombre,
                'id_area' => $usuariosareas->id_area,
                'area' => $usuariosareas->area
            ]; 
        }

        return [
            'usuariosareas' => $usuariosarea,
        ];
    }
}
