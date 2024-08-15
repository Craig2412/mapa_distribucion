<?php

namespace App\Action\Empresas;

use App\Domain\Empresas\Data\EmpresasFinderResult;
use App\Domain\Empresas\Service\EmpresasFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EmpresasFinderAction
{
    private EmpresasFinder $empresasFinder;

    private JsonRenderer $renderer;

    public function __construct(EmpresasFinder $empresasFinder, JsonRenderer $jsonRenderer)
    {
        $this->empresasFinder = $empresasFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $empresass = $this->empresasFinder->findEmpresass();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($empresass));
    }

    public function transform(EmpresasFinderResult $result): array
    {
        $empresass = [];

        foreach ($result->empresass as $empresas) {
            $empresass[] = [
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

        return [
            'empresass' => $empresass,
        ];
    }
}
