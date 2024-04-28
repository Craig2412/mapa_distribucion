<?php

namespace App\Domain\Funcionarios\Service;

use App\Domain\Funcionarios\Data\FuncionariosFinderItem;
use App\Domain\Funcionarios\Data\FuncionariosFinderResult;
use App\Domain\Funcionarios\Repository\FuncionariosFinderRepository;

final class FuncionariosFinder
{
    private FuncionariosFinderRepository $repository;

    public function __construct(FuncionariosFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findFuncionarioss($where): FuncionariosFinderResult
    {
        // Input validation
        // ...

        $funcionarioss = $this->repository->findFuncionarioss($where);

        return $this->createResult($funcionarioss);
    }

    private function createResult(array $funcionariosRows): FuncionariosFinderResult
    {
        $result = new FuncionariosFinderResult();

        foreach ($funcionariosRows as $funcionariosRow) {
        $funcionarios = new FuncionariosFinderItem();
            $funcionarios->id = $funcionariosRow['id'];
            $funcionarios->cedula = $funcionariosRow['cedula'];
            $funcionarios->apellidos_nombres = $funcionariosRow['apellidos_nombres'];
            $funcionarios->telefono = $funcionariosRow['telefono'];
            $funcionarios->correo = $funcionariosRow['correo'];
            $funcionarios->serial_carnet = $funcionariosRow['serial_carnet'];
            $funcionarios->codigo_carnet = $funcionariosRow['codigo_carnet'];
            $funcionarios->estado = $funcionariosRow['estado'];
            $funcionarios->municipio = $funcionariosRow['municipio'];
            $funcionarios->localidad = $funcionariosRow['localidad'];
            $funcionarios->departamento = $funcionariosRow['departamento'];
            $funcionarios->entidad_principal = $funcionariosRow['entidad_principal'];
            $funcionarios->entidad_adscripcion = $funcionariosRow['entidad_adscripcion'];
            $funcionarios->nombre_centro_votacion = $funcionariosRow['nombre_centro_votacion'];
            $funcionarios->id_estatus = $funcionariosRow['id_estatus'];
            $funcionarios->estatus = $funcionariosRow['estatus'];
            $funcionarios->created = $funcionariosRow['created'];
            $funcionarios->updated = $funcionariosRow['updated'];
            

            $result->funcionarioss[] = $funcionarios;
        }
        //var_dump($result);

        return $result;
    }
}
