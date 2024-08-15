<?php

namespace App\Domain\Empresas\Service;

use App\Domain\Empresas\Data\EmpresasReaderResult;
use App\Domain\Empresas\Repository\EmpresasRepository;

/**
 * Service.
 */
final class EmpresasReader
{
    private EmpresasRepository $repository;

    /**
     * The constructor.
     *
     * @param EmpresasRepository $repository The repository
     */
    public function __construct(EmpresasRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a empresas.
     *
     * @param int $empresasId The empresas id
     *
     * @return EmpresasReaderResult The result
     */
    public function getEmpresas(int $empresasId): EmpresasReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $empresasRow = $this->repository->getEmpresasById($empresasId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new EmpresasReaderResult();
        $result->id = $empresasRow['id'];
        $result->razon_social = $empresasRow['razon_social'];
        $result->coordenadas_x = $empresasRow['coordenadas_x'];
        $result->coordenadas_y = $empresasRow['coordenadas_y'];
        $result->rif = $empresasRow['rif'];
        $result->id_estado = $empresasRow['id_estado'];
        $result->id_municipio = $empresasRow['id_municipio'];
        $result->id_parroquia = $empresasRow['id_parroquia'];
        $result->id_representante_legal = $empresasRow['id_representante_legal'];
        $result->telefono = $empresasRow['telefono'];
        $result->correo = $empresasRow['correo'];
        $result->sector = $empresasRow['sector'];
        $result->sub_sector = $empresasRow['sub_sector'];
        
        return $result;
    }
}
