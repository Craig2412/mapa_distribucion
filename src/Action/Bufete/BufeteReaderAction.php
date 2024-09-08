<?php

namespace App\Action\Bufete;

use App\Domain\Bufete\Data\BufeteReaderResult;
use App\Domain\Bufete\Service\BufeteReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BufeteReaderAction
{
    private BufeteReader $bufetesReader;

    private JsonRenderer $renderer;

    public function __construct(BufeteReader $bufetesReader, JsonRenderer $jsonRenderer)
    {
        $this->bufetesReader = $bufetesReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $bufetesId = (int)$args['id_bufete'];

        // Invoke the domain and get the result
        $bufetes = $this->bufetesReader->getBufete($bufetesId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($bufetes));
    }

    private function transform(BufeteReaderResult $bufetes): array
    {
        return [
            'id' => $bufetes->id,
            'nombre_bufete' => $bufetes->nombre_bufete,
            'rif' => $bufetes->rif,
            'correo_bufete' => $bufetes->correo,
            'telefono_bufete' => $bufetes->telefono,
            'id_condicion' => $bufetes->id_condicion,
            'created' => $bufetes->created,
            'updated' => $bufetes->updated       
        ];
    }
}
