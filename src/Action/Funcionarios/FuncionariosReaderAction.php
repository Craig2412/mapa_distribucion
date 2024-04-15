<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Data\FuncionariosReaderResult;
use App\Domain\Funcionarios\Service\FuncionariosReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FuncionariosReaderAction
{
    private FuncionariosReader $funcionariosReader;

    private JsonRenderer $renderer;

    public function __construct(FuncionariosReader $funcionariosReader, JsonRenderer $jsonRenderer)
    {
        $this->funcionariosReader = $funcionariosReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $funcionariosId = (int)$args['funcionarios_cedula'];

        // Invoke the domain and get the result
        $funcionarios = $this->funcionariosReader->getFuncionarios($funcionariosId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($funcionarios));
    }

    private function transform(FuncionariosReaderResult $funcionarios): array
    {
        return [
            'id' => $funcionarios->id,
                'cedula' => $funcionarios->cedula,
                'apellidos_nombres' => $funcionarios->apellidos_nombres,
                'telefono' => $funcionarios->telefono,
                'correo' => $funcionarios->correo,
                'serial_carnet' => $funcionarios->serial_carnet,
                'codigo_carnet' => $funcionarios->codigo_carnet,
                'estado' => $funcionarios->estado,
                'municipio' => $funcionarios->municipio,
                'localidad' => $funcionarios->localidad,
                'nombre_centro_votacion' => $funcionarios->nombre_centro_votacion,
                'id_estatus' => $funcionarios->id_estatus,
                'created' => $funcionarios->created,
                'updated' => $funcionarios->updated
        ];
    }
}
