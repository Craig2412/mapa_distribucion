<?php

namespace App\Action\FormasMovilizacion;

use App\Domain\FormasMovilizacion\Data\FormasMovilizacionFinderResult;
use App\Domain\FormasMovilizacion\Service\FormasMovilizacionFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FormasMovilizacionFinderAction
{
    private FormasMovilizacionFinder $formasMovilizacionFinder;

    private JsonRenderer $renderer;

    public function __construct(FormasMovilizacionFinder $formasMovilizacionFinder, JsonRenderer $jsonRenderer)
    {
        $this->formasMovilizacionFinder = $formasMovilizacionFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
       $id_mayorista = (int)$args['id_mayorista'];

        $formasMovilizacions = $this->formasMovilizacionFinder->findFormasMovilizacions($id_mayorista);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($formasMovilizacions));
    }

    public function transform(FormasMovilizacionFinderResult $result): array
    {
        $formasMovilizacions = [];

        foreach ($result->formasMovilizacions as $formasMovilizacion) {
            $formasMovilizacions[] = [
                'id' => $formasMovilizacion->id,
                'id_tipo_movilizacion' => $formasMovilizacion->id_tipo_movilizacion,
                'tipo_movilizacion' => $formasMovilizacion->tipo_movilizacion,
                'id_mayorista' => $formasMovilizacion->id_mayorista
            ];
        }

        return [
            'formasMovilizacions' => $formasMovilizacions,
        ];
    }
}
