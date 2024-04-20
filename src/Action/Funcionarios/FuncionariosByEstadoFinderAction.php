<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Data\FuncionariosByEstadoFinderResult;
use App\Domain\Funcionarios\Service\FuncionariosByEstadoFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FuncionariosByEstadoFinderAction
{
    
    private FuncionariosByEstadoFinder $funcionariosByEstadoFinder;

    private JsonRenderer $renderer;

    public function __construct(FuncionariosByEstadoFinder $funcionariosByEstadoFinder, JsonRenderer $jsonRenderer)
    {

        $this->funcionariosByEstadoFinder = $funcionariosByEstadoFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        $estatusId = (int)$args['estatus'];

        $funcionariosByEstado = $this->funcionariosByEstadoFinder->findFuncionariosByEstado($estatusId);
  

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($funcionariosByEstado));
    }

    public function transform(FuncionariosByEstadoFinderResult $result): array
    {
        $funcionariosByEstado = [];

        foreach ($result->funcionariosByEstado as $funcionarioByEstado) {
            $funcionariosByEstado[] = [
                'estado' => $funcionarioByEstado->estado,
                'total' => $funcionarioByEstado->total,
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