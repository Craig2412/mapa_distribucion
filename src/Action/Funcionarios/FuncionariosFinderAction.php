<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Data\FuncionariosFinderResult;
use App\Domain\Funcionarios\Service\FuncionariosFinder;
use App\Domain\Funcionarios\Service\FuncionariosWhereGenFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FuncionariosFinderAction
{
    private FuncionariosFinder $funcionariosFinder;
    
    private FuncionariosWhereGenFinder $funcionariosWhereGenFinder;

    private JsonRenderer $renderer;


    public function __construct(FuncionariosFinder $funcionariosFinder,  JsonRenderer $jsonRenderer, FuncionariosWhereGenFinder $funcionariosWhereGenFinder)
    {
        $this->funcionariosFinder = $funcionariosFinder;
        $this->funcionariosWhereGenFinder = $funcionariosWhereGenFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $token = $request->getAttribute("jwt");
        $id_rol = $token['data']->scope +0;
        $rol = $token['data']->ente;
        $where = $this->funcionariosWhereGenFinder->findFuncionariosWhereGens($id_rol,$rol);
        if (isset($where)) {
            $funcionarioss = $this->funcionariosFinder->findFuncionarioss($where);
            return $this->renderer->json($response, $this->transform($funcionarioss));
        }else {
            return 'error';
        }

        // Transform result and render to json
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
                'estado' => strtoupper($funcionarios->estado),
                'municipio' => $funcionarios->municipio,
                'localidad' => $funcionarios->localidad,
                'nombre_centro_votacion' => $funcionarios->nombre_centro_votacion,
                'id_estatus' => $funcionarios->id_estatus,
                'estatus' => $funcionarios->estatus,
                'entidad_principal' => $funcionarios->entidad_principal,
                'entidad_adscripcion' => $funcionarios->entidad_adscripcion,
                'departamento' => $funcionarios->departamento,
                'created' => $funcionarios->created,
                'updated' => $funcionarios->updated
            ];
        }

        return [
            'funcionarioss' => $funcionarioss,
        ];
    }
}
