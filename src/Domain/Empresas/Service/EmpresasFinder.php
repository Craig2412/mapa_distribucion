<?php

namespace App\Domain\Empresas\Service;

use App\Domain\Empresas\Data\EmpresasFinderItem;
use App\Domain\Empresas\Data\EmpresasFinderResult;
use App\Domain\Empresas\Repository\EmpresasFinderRepository;

final class EmpresasFinder
{
    private EmpresasFinderRepository $repository;

    public function __construct(EmpresasFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findEmpresass(): EmpresasFinderResult
    {
        // Input validation
        // ...

        $empresass = $this->repository->findEmpresass();

        return $this->createResult($empresass);
    }

    private function createResult(array $empresasRows): EmpresasFinderResult
    {
        $result = new EmpresasFinderResult();

        foreach ($empresasRows as $empresasRow) {
            $empresas = new EmpresasFinderItem();
            $empresas->id = $empresasRow['id'];
            $empresas->razon_social = $empresasRow['razon_social'];
            $empresas->coordenadas_x = $empresasRow['coordenadas_x'];
            $empresas->coordenadas_y = $empresasRow['coordenadas_y'];
            $empresas->rif = $empresasRow['rif'];
            $empresas->id_estado = $empresasRow['id_estado'];
            $empresas->id_municipio = $empresasRow['id_municipio'];
            $empresas->id_parroquia = $empresasRow['id_parroquia'];
            $empresas->id_representante_legal = $empresasRow['id_representante_legal'];
            $empresas->telefono = $empresasRow['telefono'];
            $empresas->correo = $empresasRow['correo'];
            $empresas->sector = $empresasRow['sector'];
            $empresas->sub_sector = $empresasRow['sub_sector'];
            

            $result->empresass[] = $empresas;
        }

        return $result;
    }
}
