<?php

namespace App\Action\Requerimientos;

use App\Domain\Requerimientos\Data\RequerimientosReaderResult;
use App\Domain\Requerimientos\Service\RequerimientosReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequerimientosReaderAction
{
    private RequerimientosReader $requerimientoReader;

    private JsonRenderer $renderer;

    public function __construct(RequerimientosReader $requerimientoReader, JsonRenderer $jsonRenderer)
    {
        $this->requerimientoReader = $requerimientoReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $requerimientoId = (int)$args['id_requerimiento'];

        // Invoke the domain and get the result
        $requerimiento = $this->requerimientoReader->getRequerimientos($requerimientoId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($requerimiento));
    }

    private function transform(RequerimientosReaderResult $requerimiento): array
    {
        return [
            
            'id' => $requerimiento->id,
            'agent_name' => $requerimiento->agent_name,
            'agent_lastname' => $requerimiento->agent_lastname,
            'agent_identification' => $requerimiento->agent_identification,
            'agent_rif' => $requerimiento->agent_rif,
            'agent_gender' => $requerimiento->agent_gender,
            'type_agent_name' => $requerimiento->type_agent_name,
            'agent_number_type' => $requerimiento->agent_number_type,
            'agent_telefone' => $requerimiento->agent_telefone,
            'agent_email' => $requerimiento->agent_email,
            'agent_number' => $requerimiento->agent_number,
            'direcction_name' => $requerimiento->direcction_name,
            'estado' => $requerimiento->estado,
            'municipio' => $requerimiento->municipio,
            'parroquia' => $requerimiento->parroquia
        ];
    }
}
