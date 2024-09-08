<?php

namespace App\Domain\UsuariosAreas\Service;

use App\Domain\UsuariosAreas\Data\UsuariosAreasReaderResult;
use App\Domain\UsuariosAreas\Repository\UsuariosAreasRepository;

/**
 * Service.
 */
final class UsuariosAreasReader
{
    private UsuariosAreasRepository $repository;

    /**
     * The constructor.
     *
     * @param UsuariosAreasRepository $repository The repository
     */
    public function __construct(UsuariosAreasRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a usuariosarea.
     *
     * @param int $usuariosareaId The usuariosarea id
     *
     * @return UsuariosAreasReaderResult The result
     */
    public function getUsuariosAreas(int $usuariosareaId): UsuariosAreasReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $usuariosareaRow = $this->repository->getUsuariosAreasById($usuariosareaId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new UsuariosAreasReaderResult();
        $result->id = $usuariosareaRow['id'];
        $result->nombre = $usuariosareaRow['nombre'];
        $result->id_usuario = $usuariosareaRow['id_usuario'];
        $result->area = $usuariosareaRow['area'];
        $result->id_area = $usuariosareaRow['id_area'];
        
        return $result;
    }
}