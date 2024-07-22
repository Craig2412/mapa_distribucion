<?php

namespace App\Domain\Estatus_aplicacion\Service;

use App\Domain\Estatus_aplicacion\Data\Estatus_aplicacionReaderResult;
use App\Domain\Estatus_aplicacion\Repository\Estatus_aplicacionRepository;

/**
 * Service.
 */
final class Estatus_aplicacionReader
{
    private Estatus_aplicacionRepository $repository;

    /**
     * The constructor.
     *
     * @param Estatus_aplicacionRepository $repository The repository
     */
    public function __construct(Estatus_aplicacionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a estatus_aplicacion.
     *
     * @param int $estatus_aplicacionId The estatus_aplicacion id
     *
     * @return Estatus_aplicacionReaderResult The result
     */
    public function getEstatus_aplicacion(int $estatus_aplicacionId): Estatus_aplicacionReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $estatus_aplicacionRow = $this->repository->getEstatus_aplicacionById($estatus_aplicacionId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new Estatus_aplicacionReaderResult();
        $result->id = $estatus_aplicacionRow['id'];
        $result->estatus_aplicacion = $estatus_aplicacionRow['estatus_aplicacion'];
        
        return $result;
    }
}
