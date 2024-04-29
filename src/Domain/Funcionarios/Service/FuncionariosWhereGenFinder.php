<?php

namespace App\Domain\Funcionarios\Service;

use App\Domain\Funcionarios\Data\FuncionariosWhereGenFinderItem;
use App\Domain\Funcionarios\Data\FuncionariosWhereGenFinderResult;
use App\Domain\Funcionarios\Repository\FuncionariosWhereGenFinderRepository;

final class FuncionariosWhereGenFinder
{
    private FuncionariosWhereGenFinderRepository $repository;   

    public function __construct(FuncionariosWhereGenFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findFuncionariosWhereGens(int $id_rol, string $rol)
    {
        $funcionariosWhereGens = $this->repository->findFuncionariosWhereGens($id_rol,$rol);

        return $this->createResult($funcionariosWhereGens,$rol);
    }

    private function createResult(array $funcionariosWhereGenRows,$rol)  
    {

        if (count($funcionariosWhereGenRows) === 0) {

           $funcionariosWhereGenRows = [["ente" => $rol]];
        }
        $where_props = [];
        $filas = 'funcionarios.entidad_adscripcion';
        
        foreach ($funcionariosWhereGenRows as $funcionariosWhereGenRow) {     
            $value = strtoupper($funcionariosWhereGenRow['ente']);
            $where_props = [...$where_props, "$value" => $filas];     
        }



        return  $where_props;
    }
}
