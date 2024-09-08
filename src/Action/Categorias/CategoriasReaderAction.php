<?php

namespace App\Action\Categorias;

use App\Domain\Categorias\Data\CategoriasReaderResult;
use App\Domain\Categorias\Service\CategoriasReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CategoriasReaderAction
{
    private CategoriasReader $categoriaReader;

    private JsonRenderer $renderer;

    public function __construct(CategoriasReader $categoriaReader, JsonRenderer $jsonRenderer)
    {
        $this->categoriaReader = $categoriaReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $categoriaId = (int)$args['categoria_id'];

        // Invoke the domain and get the result
        $categoria = $this->categoriaReader->getCategorias($categoriaId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($categoria));
    }

    private function transform(CategoriasReaderResult $categoria): array
    {
        return [
            'id' => $categoria->id,
            'categoria' => $categoria->categoria,
            'id_departamento' => $categoria->id_departamento,
            'departamento' => $categoria->departamento,
            'id_condicion' => $categoria->id_condicion,
            'created' => $categoria->created,
            'updated' => $categoria->updated
        ];
    }
}
