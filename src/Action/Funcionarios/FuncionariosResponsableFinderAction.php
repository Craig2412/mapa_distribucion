<?php

namespace App\Action\Funcionarios;

use App\Domain\Funcionarios\Data\FuncionariosFinderResult;
use App\Domain\Funcionarios\Service\FuncionariosResponsableFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FuncionariosResponsableFinderAction
{
    private FuncionariosResponsableFinder $funcionariosResponsableFinder;

    private JsonRenderer $renderer;


    public function __construct(FuncionariosResponsableFinder $funcionariosResponsableFinder,  JsonRenderer $jsonRenderer)
    {
        $this->funcionariosResponsableFinder = $funcionariosResponsableFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $cedulaResponsable = (int)$args['responsable_cedula'];

        if ($cedulaResponsable == 0) {
            return $this->renderer->json($response, 'Cedula no valida para la busqueda');
        }else {
            $funcionariosResponsables = $this->funcionariosResponsableFinder->findFuncionariosResponsables($cedulaResponsable);
            return $this->renderer->json($response, $this->transform($funcionariosResponsables));
        }
      
    }

    public function transform(FuncionariosFinderResult $result): array
    {
        $funcionariosResponsables = [];

        foreach ($result->funcionariosResponsables as $funcionariosResponsable) {
            $funcionariosResponsables[] = [
                'id' => $funcionariosResponsable->id,
                'cedula' => $funcionariosResponsable->cedula,
                'apellidos_nombres' => $funcionariosResponsable->apellidos_nombres,
                'telefono' => $funcionariosResponsable->telefono,
                'estado' => strtoupper($funcionariosResponsable->estado),
                'id_estatus' => $funcionariosResponsable->id_estatus,
                'estatus' => $funcionariosResponsable->estatus,
                'entidad_adscripcion' => $funcionariosResponsable->entidad_adscripcion,
                'cantidad_responsable' => $funcionariosResponsable->cantidad_responsable,
            ];
        }

        return [
            'funcionariosResponsables' => $funcionariosResponsables,
        ];
    }
}
