<?php

namespace App\Action\Categorias;

use App\Domain\Categorias\Service\CategoriasDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CategoriasDeleterAction
{
    private CategoriasDeleter $categoriasDeleter;

    private JsonRenderer $renderer;

    public function __construct(CategoriasDeleter $categoriasDeleter, JsonRenderer $renderer)
    {
        $this->categoriasDeleter = $categoriasDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $categoriasId = (int)$args['categoria_id'];
        // Invoke the domain (service class)
        $this->categoriasDeleter->deleteCategorias($categoriasId);
        // Render the json response
        return $this->renderer->json($response, 'Registro eliminado');
    }
}
