<?php

namespace App\Action\Categorias;

use App\Domain\Categorias\Service\CategoriasUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CategoriasUpdaterAction
{
    private CategoriasUpdater $categoriasUpdater;

    private JsonRenderer $renderer;

    public function __construct(CategoriasUpdater $categoriasUpdater, JsonRenderer $jsonRenderer)
    {
        $this->categoriasUpdater = $categoriasUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $categoriasId = (int)$args['categoria_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $new_date = $this->categoriasUpdater->updateCategorias($categoriasId, $data);

        // Build the HTTP response
        return $this->renderer->json($response,['datosNuevos' => $new_date]);
    }
}
