<?php

namespace App\Action\UsuariosBufetes;

use App\Domain\UsuariosBufetes\Data\UsuariosBufetesReaderResult;
use App\Domain\UsuariosBufetes\Service\UsuariosBufetesReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuariosBufetesReaderAction
{
    private UsuariosBufetesReader $usuariosbufeteReader;

    private JsonRenderer $renderer;

    public function __construct(UsuariosBufetesReader $usuariosbufeteReader, JsonRenderer $jsonRenderer)
    {
        $this->usuariosbufeteReader = $usuariosbufeteReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $usuariosbufeteId = (int)$args['usuarios_bufete_id'];

        // Invoke the domain and get the result
        $usuariosbufete = $this->usuariosbufeteReader->getUsuariosBufetes($usuariosbufeteId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($usuariosbufete));
    }

    private function transform(UsuariosBufetesReaderResult $usuariosbufete): array
    {
        return [
                'id' => $usuariosbufete->id,
                'id_usuario' => $usuariosbufete->id_usuario,
                'nombre' => $usuariosbufete->nombre,
                'id_bufete' => $usuariosbufete->id_bufete,
                'bufete' => $usuariosbufete->bufete
        ];
    }
}
