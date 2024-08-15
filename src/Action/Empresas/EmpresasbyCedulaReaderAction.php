<?php

namespace App\Action\Empresas;

use App\Domain\Empresas\Data\EmpresasReaderResult;
use App\Domain\Empresas\Service\EmpresasbyCedulaReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EmpresasbyCedulaReaderAction
{
    private EmpresasbyCedulaReader $empresasbyCedulaReader;

    private JsonRenderer $renderer;

    public function __construct(EmpresasbyCedulaReader $empresasbyCedulaReader, JsonRenderer $jsonRenderer)
    {
        $this->empresasbyCedulaReader = $empresasbyCedulaReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $empresasbyCedulaId = (string)$args['empresa_rif'];

        // Invoke the domain and get the result
        $empresasbyCedula = $this->empresasbyCedulaReader->getEmpresasbyCedula($empresasbyCedulaId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($empresasbyCedula));
    }

    private function transform(EmpresasReaderResult $empresasbyCedula): array
    {
        return [
           'id' => $empresasbyCedula->id,
            'razon_social' => $empresasbyCedula->razon_social,
            'coordenadas_x' => $empresasbyCedula->coordenadas_x,
            'coordenadas_y' => $empresasbyCedula->coordenadas_y,
            'rif' => $empresasbyCedula->rif,
            'id_estado' => $empresasbyCedula->id_estado,
            'id_municipio' => $empresasbyCedula->id_municipio,
            'id_parroquia' => $empresasbyCedula->id_parroquia,
            'id_representante_legal' => $empresasbyCedula->id_representante_legal,
            'telefono' => $empresasbyCedula->telefono,
            'correo' => $empresasbyCedula->correo,
            'sector' => $empresasbyCedula->sector,
            'sub_sector' => $empresasbyCedula->sub_sector
        ];
    }
}
