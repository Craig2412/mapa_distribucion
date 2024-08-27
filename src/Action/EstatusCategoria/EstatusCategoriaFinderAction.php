<?php

namespace App\Action\EstatusCategoria;

use App\Domain\EstatusCategoria\Data\EstatusCategoriaFinderResult;
use App\Domain\EstatusCategoria\Service\EstatusCategoriaFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EstatusCategoriaFinderAction
{
    private EstatusCategoriaFinder $estatusCategoriasFinder;

    private JsonRenderer $renderer;

    public function __construct(EstatusCategoriaFinder $estatusCategoriasFinder, JsonRenderer $jsonRenderer)
    {
        $this->estatusCategoriasFinder = $estatusCategoriasFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $estatusCategoriass = $this->estatusCategoriasFinder->findEstatusCategorias();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($estatusCategoriass));
    }

    public function transform(EstatusCategoriaFinderResult $result): array
    {
        $estatusCategoriass = [];
        
        foreach ($result->estatusCategoriass as $estatusCategorias) {
            $estatusCategoriass[] = [
                'id' => $estatusCategorias->id,
                'categoria' => $estatusCategorias->categoria,           
                'estatusCategoria' => $estatusCategorias->estatusCategoria,
                'id_categoria' => $estatusCategorias->id_categoria,           
                'created' => $estatusCategorias->created,           
                'updated' => $estatusCategorias->updated
            ];
        }

        return [
            'estatusCategoriass' => $estatusCategoriass,
        ];
    }
}
