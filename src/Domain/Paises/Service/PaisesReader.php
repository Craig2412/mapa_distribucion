<?php

namespace App\Domain\Paises\Service;

use App\Domain\Paises\Data\PaisesReaderResult;
use App\Domain\Paises\Repository\PaisesRepository;

/**
 * Service.
 */
final class PaisesReader
{
    private PaisesRepository $repository;

    /**
     * The constructor.
     *
     * @param PaisesRepository $repository The repository
     */
    public function __construct(PaisesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a paises.
     *
     * @param int $paisesId The paises id
     *
     * @return PaisesReaderResult The result
     */
    public function getPaises(int $paisesId): PaisesReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $paisesRow = $this->repository->getPaisesById($paisesId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new PaisesReaderResult();
        $result->id = $paisesRow['id'];
        $result->pais = $paisesRow['pais'];
        
        return $result;
    }
}
