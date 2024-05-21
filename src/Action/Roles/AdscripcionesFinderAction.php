<?php

namespace App\Action\Roles;

use App\Domain\Roles\Data\AdscripcionesFinderResult;
use App\Domain\Roles\Service\AdscripcionesFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AdscripcionesFinderAction
{
    private AdscripcionesFinder $adscripcionesFinder;

    private JsonRenderer $renderer;

    public function __construct(AdscripcionesFinder $adscripcionesFinder, JsonRenderer $jsonRenderer)
    {
        $this->adscripcionesFinder = $adscripcionesFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $token = $request->getAttribute("jwt");
        
        $adscripcioness = $this->adscripcionesFinder->findAdscripcioness($token['data']->scope,$token['data']->ente);
       
        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($adscripcioness));
    }

    public function transform(AdscripcionesFinderResult $result): array
    {
        
        $adscripcioness = [];

        foreach ($result->adscripcioness as $Adscripciones) {
            $adscripcioness[] = [
                'id' => $Adscripciones->id,
                'ente' => $Adscripciones->ente,
                'ente_principal' => $Adscripciones->ente_principal
            ];
        }

        return [
            'adscripcioness' => $adscripcioness,
        ];
    }
}
