<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Data\FuncionariosByEstatusFinderResult;
use App\Domain\Funcionarios\Service\FuncionariosByEstatusFinder;
use App\Domain\Funcionarios\Service\FuncionariosWhereGenFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FuncionariosByEstatusFinderAction
{
    
    private FuncionariosByEstatusFinder $funcionariosByEstatusFinder;

    private FuncionariosWhereGenFinder $funcionariosWhereGenFinder;

    private JsonRenderer $renderer;

    public function __construct(FuncionariosByEstatusFinder $funcionariosByEstatusFinder, JsonRenderer $jsonRenderer, FuncionariosWhereGenFinder $funcionariosWhereGenFinder)
    {

        $this->funcionariosByEstatusFinder = $funcionariosByEstatusFinder;
        $this->funcionariosWhereGenFinder = $funcionariosWhereGenFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $estatusId = (int)$args['estatus'];

        $token = $request->getAttribute("jwt");
        $id_rol = $token['data']->scope +0;
        $rol = $token['data']->ente;

        if (isset($args['params'])) {
            $params = explode('/', $args['params']);
            $where = $params[0];       
        }else {
            $where = $rol;       
        }

        //$where = $this->funcionariosWhereGenFinder->findFuncionariosWhereGens($id_rol,$rol);
        if (isset($where)) {
            $funcionariosByEstatus = $this->funcionariosByEstatusFinder->findFuncionariosByEstatus($estatusId,$where);
            // Transform result and render to json
            return $this->renderer->json($response, $this->transform($funcionariosByEstatus));
        }else {
            return 'error';
        }

    }

    public function transform(FuncionariosByEstatusFinderResult $result): array
    {
        $funcionariosByEstatus = [];

        foreach ($result->funcionariosByEstatus as $funcionarioByEstatus) {
            $funcionariosByEstatus[] = [
                'estatus' => $funcionarioByEstatus->estatus,
                'total' => $funcionarioByEstatus->total,
            ];
        }

        return [
            'funcionariosByEstatus' => $funcionariosByEstatus,
        ];
    }
}
/*


EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_funcionariosByEstatus": "some_surname"}
*/