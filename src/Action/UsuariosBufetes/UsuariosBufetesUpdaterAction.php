<?php

namespace App\Action\UsuariosBufetes;

use App\Domain\UsuariosBufetes\Service\UsuariosBufetesUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsuariosBufetesUpdaterAction
{
    private UsuariosBufetesUpdater $usuariosbufetesUpdater;

    private JsonRenderer $renderer;

    public function __construct(UsuariosBufetesUpdater $usuariosbufetesUpdater, JsonRenderer $jsonRenderer)
    {
        $this->usuariosbufetesUpdater = $usuariosbufetesUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $usuariosbufetesId = (int)$args['usuarios_bufete_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_date = $this->usuariosbufetesUpdater->updateUsuariosBufetes($usuariosbufetesId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datosNuevos' => $new_date]);
    }
}
