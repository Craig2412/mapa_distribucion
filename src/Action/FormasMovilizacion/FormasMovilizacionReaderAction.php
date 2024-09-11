<?php

namespace App\Action\FormasMovilizacion;

use App\Domain\FormasMovilizacion\Data\FormasMovilizacionReaderResult;
use App\Domain\FormasMovilizacion\Service\FormasMovilizacionReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FormasMovilizacionReaderAction
{
    private FormasMovilizacionReader $formasMovilizacionReader;

    private JsonRenderer $renderer;

    public function __construct(FormasMovilizacionReader $formasMovilizacionReader, JsonRenderer $jsonRenderer)
    {
        $this->formasMovilizacionReader = $formasMovilizacionReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $formasMovilizacionId = (int)$args['formasMovilizacion_id'];

        // Invoke the domain and get the result
        $formasMovilizacion = $this->formasMovilizacionReader->getFormasMovilizacion($formasMovilizacionId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($formasMovilizacion));
    }

    private function transform(FormasMovilizacionReaderResult $formasMovilizacion): array
    {
        return [
            'id' => $formasMovilizacion->id,
            'id_tipo_movilizacion' => $formasMovilizacion->id_tipo_movilizacion,
            'tipo_movilizacion' => $formasMovilizacion->tipo_movilizacion,
            'id_mayorista' => $formasMovilizacion->id_mayorista
        ];
    }
}
