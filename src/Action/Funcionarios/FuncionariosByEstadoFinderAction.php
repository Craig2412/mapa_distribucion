<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Data\FuncionariosByEstadoFinderResult;
use App\Domain\Funcionarios\Service\FuncionariosWhereGenFinder;
use App\Domain\Funcionarios\Service\FuncionariosByEstadoFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FuncionariosByEstadoFinderAction
{
    
    private FuncionariosByEstadoFinder $funcionariosByEstadoFinder;

    private FuncionariosWhereGenFinder $funcionariosWhereGenFinder;

    private JsonRenderer $renderer;

    public function __construct(FuncionariosByEstadoFinder $funcionariosByEstadoFinder, JsonRenderer $jsonRenderer, FuncionariosWhereGenFinder $funcionariosWhereGenFinder)
    {

        $this->funcionariosByEstadoFinder = $funcionariosByEstadoFinder;
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
            $funcionariosByEstado = $this->funcionariosByEstadoFinder->findFuncionariosByEstado($estatusId,$where);
            // Transform result and render to json
            return $this->renderer->json($response, $this->transform($funcionariosByEstado));
        }else {
            return 'error';
        }

    }

    public function transform(FuncionariosByEstadoFinderResult $result): array
    {
        $funcionariosByEstado = [];

        foreach ($result->funcionariosByEstado as $funcionarioByEstado) {
            $funcionariosByEstado[] = [
                'estado' => $funcionarioByEstado->estado,
                'total' => $funcionarioByEstado->total,
                'total_no' => $funcionarioByEstado->total_no,
                'total_sin' => $funcionarioByEstado->total_sin,
            ];
        }

        return [
            'funcionariosByEstado' => $funcionariosByEstado,
        ];
    }
}
/*


EJEMPLO DEL STRING QUE SE DEBE ENVIAR POR LOS PARAMETROS CON FORMATO JSON:
    {"area": "some_value", "status": "some_name", "type_funcionariosByEstado": "some_surname"}
*/