<?php

namespace App\Action\EstatusCategoria;

use App\Domain\EstatusCategoria\Data\EstatusCategoriaReaderResult;
use App\Domain\EstatusCategoria\Service\EstatusCategoriaReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EstatusCategoriaReaderAction
{
    private EstatusCategoriaReader $estatusCategoriasReader;

    private JsonRenderer $renderer;

    public function __construct(EstatusCategoriaReader $estatusCategoriasReader, JsonRenderer $jsonRenderer)
    {
        $this->estatusCategoriasReader = $estatusCategoriasReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $estatusCategoriasId = (int)$args['estatus_id'];

        // Invoke the domain and get the result
        $estatusCategorias = $this->estatusCategoriasReader->getEstatusCategoria($estatusCategoriasId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($estatusCategorias));
    }

    private function transform(EstatusCategoriaReaderResult $estatusCategorias): array
    {
        return [
            'id' => $estatusCategorias->id,
            'categoria' => $estatusCategorias->categoria,           
            'estatusCategoria' => $estatusCategorias->estatusCategoria,           
            'id_categoria' => $estatusCategorias->id_categoria,           
            'created' => $estatusCategorias->created,           
            'updated' => $estatusCategorias->updated,           
        ];
    }
}
