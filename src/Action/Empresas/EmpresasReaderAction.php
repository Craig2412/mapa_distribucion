<?php

namespace App\Action\Empresas;

use App\Domain\Empresas\Data\EmpresasReaderResult;
use App\Domain\Empresas\Service\EmpresasReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EmpresasReaderAction
{
    private EmpresasReader $empresasReader;

    private JsonRenderer $renderer;

    public function __construct(EmpresasReader $empresasReader, JsonRenderer $jsonRenderer)
    {
        $this->empresasReader = $empresasReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $empresasId = (int)$args['empresas_id'];

        // Invoke the domain and get the result
        $empresas = $this->empresasReader->getEmpresas($empresasId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($empresas));
    }

    private function transform(EmpresasReaderResult $empresas): array
    {
        return [
            'id' => $empresas->id,
            'razon_social' => $empresas->razon_social,
            'coordenadas_x' => $empresas->coordenadas_x,
            'coordenadas_y' => $empresas->coordenadas_y,
            'rif' => $empresas->rif,
            'id_estado' => $empresas->id_estado,
            'id_municipio' => $empresas->id_municipio,
            'id_parroquia' => $empresas->id_parroquia,
            'id_representante_legal' => $empresas->id_representante_legal,
            'telefono' => $empresas->telefono,
            'correo' => $empresas->correo,
            'sector' => $empresas->sector,
            'sub_sector' => $empresas->sub_sector
        ];
    }
}
