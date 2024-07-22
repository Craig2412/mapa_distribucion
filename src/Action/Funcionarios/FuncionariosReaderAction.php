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
        $funcionariosId = (int)$args['funcionario_cedula'];
        $type = (int)$args['arg'];
        
        // Invoke the domain and get the result
        $funcionarios = $this->funcionariosReader->getFuncionarios($funcionariosId, $type);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($funcionarios, $type));
    }

    private function transform(FuncionariosReaderResult $funcionarios, int $type): array
    {
        if ($funcionarios->id_estatus != 3 && $type==1) {
            return ['error' => 'Encuesta respondida'];
        }else {
            return [
                'id' => $funcionarios->id,
                'cedula' => $funcionarios->cedula,
                'apellidos_nombres' => $funcionarios->apellidos_nombres,
                'telefono' => $funcionarios->telefono,
                'correo' => $funcionarios->correo,
                'serial_carnet' => $funcionarios->serial_carnet,
                'codigo_carnet' => $funcionarios->codigo_carnet,    
                'estado' => strtoupper($funcionarios->estado),
                'municipio' => $funcionarios->municipio,
                'localidad' => $funcionarios->localidad,
                'nombre_centro_votacion' => $funcionarios->nombre_centro_votacion,
                'id_estatus' => $funcionarios->id_estatus,
                'entidad_principal' => $funcionarios->entidad_principal,
                'entidad_adscripcion' => $funcionarios->entidad_adscripcion,
                'departamento' => $funcionarios->departamento,
                'responsable' => $funcionarios->responsable,
                'created' => $funcionarios->created,
                'updated' => $funcionarios->updated
            ];
        }
    }
}
