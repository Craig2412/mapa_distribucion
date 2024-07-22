<?php

namespace App\Domain\Funcionarios\Service;

use App\Domain\Funcionarios\Data\FuncionariosFinderItem;
use App\Domain\Funcionarios\Data\FuncionariosFinderResult;
use App\Domain\Funcionarios\Repository\FuncionariosResponsableFinderRepository;

final class FuncionariosResponsableFinder
{
    private FuncionariosResponsableFinderRepository $repository;

    public function __construct(FuncionariosResponsableFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findFuncionariosResponsables($cedulaResponsable): FuncionariosFinderResult
    {
        
        $funcionariosResponsables = $this->repository->findFuncionariosResponsables($cedulaResponsable);
        return $this->createResult($funcionariosResponsables);
    }

    private function createResult(array $funcionariosResponsableRows): FuncionariosFinderResult
    {
        $result = new FuncionariosFinderResult();

        foreach ($funcionariosResponsableRows as $funcionariosResponsableRow) {
        $funcionariosResponsable = new FuncionariosFinderItem();
            $funcionariosResponsable->id = $funcionariosResponsableRow['id'];
            $funcionariosResponsable->cedula = $funcionariosResponsableRow['cedula'];
            $funcionariosResponsable->apellidos_nombres = $funcionariosResponsableRow['apellidos_nombres'];
            $funcionariosResponsable->telefono = $funcionariosResponsableRow['telefono'];
            $funcionariosResponsable->estado = $funcionariosResponsableRow['estado'];
            $funcionariosResponsable->entidad_adscripcion = $funcionariosResponsableRow['entidad_adscripcion'];
            $funcionariosResponsable->id_estatus = $funcionariosResponsableRow['id_estatus'];
           $funcionariosResponsable->estatus = $funcionariosResponsableRow['estatus'];
        
            $result->funcionariosResponsables[] = $funcionariosResponsable;
        }

        return $result;
    }
}

