<?php

namespace App\Domain\Empresas\Service;

use App\Domain\Empresas\Data\EmpresasReaderResult;
use App\Domain\Empresas\Repository\EmpresasRepository;

/**
 * Service.
 */
final class EmpresasbyCedulaReader
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
     * Read a empresasbyCedula.
     *
     * @param int $empresasbyCedulaId The empresasbyCedula id
     *
     * @return EmpresasReaderResult The result
     */
    public function getEmpresasbyCedula(string $empresasbyCedulaId): EmpresasReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $empresasbyCedulaRow = $this->repository->getEmpresasbyCedulaById($empresasbyCedulaId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new EmpresasReaderResult();
        $result->id = $empresasbyCedulaRow['id'];
        $result->razon_social = $empresasbyCedulaRow['razon_social'];
        $result->coordenadas_x = $empresasbyCedulaRow['coordenadas_x'];
        $result->coordenadas_y = $empresasbyCedulaRow['coordenadas_y'];
        $result->rif = $empresasbyCedulaRow['rif'];
        $result->id_estado = $empresasbyCedulaRow['id_estado'];
        $result->id_municipio = $empresasbyCedulaRow['id_municipio'];
        $result->id_parroquia = $empresasbyCedulaRow['id_parroquia'];
        $result->id_representante_legal = $empresasbyCedulaRow['id_representante_legal'];
        $result->telefono = $empresasbyCedulaRow['telefono'];
        $result->correo = $empresasbyCedulaRow['correo'];
        $result->sector = $empresasbyCedulaRow['sector'];
        $result->sub_sector = $empresasbyCedulaRow['sub_sector'];
        
        return $result;
    }
}
