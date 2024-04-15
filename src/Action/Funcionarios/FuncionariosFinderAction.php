<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Data\FuncionariosFinderResult;
use App\Domain\Funcionarios\Service\FuncionariosFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FuncionariosFinderAction
{
    private FuncionariosFinder $funcionariosFinder;

    private JsonRenderer $renderer;

    public function __construct(FuncionariosFinder $funcionariosFinder, JsonRenderer $jsonRenderer)
    {
        $this->funcionariosFinder = $funcionariosFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $funcionarioss = $this->funcionariosFinder->findFuncionarioss();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($funcionarioss));
    }

    public function transform(FuncionariosFinderResult $result): array
    {
        $funcionarioss = [];

        foreach ($result->funcionarioss as $funcionarios) {
            $funcionarioss[] = [
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

        return [
            'funcionarioss' => $funcionarioss,
        ];
    }
}
