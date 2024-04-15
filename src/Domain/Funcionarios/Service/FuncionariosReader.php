<?php

namespace App\Domain\Funcionarios\Service;

use App\Domain\Funcionarios\Data\FuncionariosReaderResult;
use App\Domain\Funcionarios\Repository\FuncionariosRepository;

/**
 * Service.
 */
final class FuncionariosReader
{
    private FuncionariosRepository $repository;

    /**
     * The constructor.
     *
     * @param FuncionariosRepository $repository The repository
     */
    public function __construct(FuncionariosRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a funcionarios.
     *
     * @param int $funcionariosId The funcionarios id
     *
     * @return FuncionariosReaderResult The result
     */
    public function getFuncionarios(int $funcionariosId): FuncionariosReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $funcionariosRow = $this->repository->getFuncionariosById($funcionariosId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new FuncionariosReaderResult();
        $result->id = $funcionariosRow['id'];
        $result->cedula = $funcionariosRow['cedula'];
        $result->apellidos_nombres = $funcionariosRow['apellidos_nombres'];
        $result->telefono = $funcionariosRow['telefono'];
        $result->correo = $funcionariosRow['correo'];
        $result->serial_carnet = $funcionariosRow['serial_carnet'];
        $result->codigo_carnet = $funcionariosRow['codigo_carnet'];
        $result->estado = $funcionariosRow['estado'];
        $result->municipio = $funcionariosRow['municipio'];
        $result->localidad = $funcionariosRow['localidad'];
        $result->nombre_centro_votacion = $funcionariosRow['nombre_centro_votacion'];
        $result->id_estatus = $funcionariosRow['id_estatus'];
        $result->estatus = $funcionariosRow['estatus'];
        $result->created = $funcionariosRow['created'];
        $result->updated = $funcionariosRow['updated'];
        
        return $result;
    }
}