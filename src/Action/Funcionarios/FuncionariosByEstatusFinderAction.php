<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Data\FuncionariosByEstatusFinderResult;
use App\Domain\Funcionarios\Service\FuncionariosByEstatusFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FuncionariosByEstatusFinderAction
{
    
    private FuncionariosByEstatusFinder $funcionariosByEstatusFinder;

    private JsonRenderer $renderer;

    public function __construct(FuncionariosByEstatusFinder $funcionariosByEstatusFinder, JsonRenderer $jsonRenderer)
    {

        $this->funcionariosByEstatusFinder = $funcionariosByEstatusFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        $estatusId = (int)$args['estatus'];

        $funcionariosByEstatus = $this->funcionariosByEstatusFinder->findFuncionariosByEstatus($estatusId);
  

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($funcionariosByEstatus));
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