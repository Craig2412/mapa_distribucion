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
                'estado' => strtoupper($funcionarios->estado),
                'id_estatus' => $funcionarios->id_estatus,
                'estatus' => $funcionarios->estatus,
                'entidad_adscripcion' => $funcionarios->entidad_adscripcion,
                'cantidad_responsable' => $funcionarios->cantidad_responsable!=='N/A'?'SI':'NO',
                'porcentaje' => bcdiv($funcionarios->porcentaje, '1', 2)
            ];
        }

        return [
            'funcionarioss' => $funcionarioss,
        ];
    }
}
