<?php

namespace App\Action\UsuariosBufetes;

use App\Domain\UsuariosBufetes\Data\UsuariosBufetesFinderResult;
use App\Domain\UsuariosBufetes\Service\UsuariosBufetesFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuariosBufetesFinderAction
{
    private UsuariosBufetesFinder $UsuariosBufetesFinder;

    private JsonRenderer $renderer;

    public function __construct(UsuariosBufetesFinder $UsuariosBufetesFinder, JsonRenderer $jsonRenderer)
    {
        $this->usuariosbufetesFinder = $UsuariosBufetesFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $usuariosbufetes = $this->usuariosbufetesFinder->findusuariosbufetes();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($usuariosbufetes));
    }

    public function transform(UsuariosBufetesFinderResult $result): array
    {
        $usuariosbufetes = [];

        foreach ($result->usuariosbufetes as $usuariosbufetes) {
            $usuariosbufete[] = [
                'id' => $usuariosbufetes->id,
                'id_usuario' => $usuariosbufetes->id_usuario,
                'nombre' => $usuariosbufetes->nombre,
                'id_bufete' => $usuariosbufetes->id_bufete,
                'bufete' => $usuariosbufetes->bufete
            ]; 
        }

        return [
            'usuariosbufetes' => $usuariosbufete,
        ];
    }
}
