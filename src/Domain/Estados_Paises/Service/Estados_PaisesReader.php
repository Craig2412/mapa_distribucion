<?php

namespace App\Domain\Estados_Paises\Service;

use App\Domain\Estados_Paises\Data\Estados_PaisesReaderResult;
use App\Domain\Estados_Paises\Repository\Estados_PaisesRepository;

/**
 * Service.
 */
final class Estados_PaisesReader
{
    private Estados_PaisesRepository $repository;

    /**
     * The constructor.
     *
     * @param Estados_PaisesRepository $repository The repository
     */
    public function __construct(Estados_PaisesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a estados_paises.
     *
     * @param int $estados_paisesId The estados_paises id
     *
     * @return Estados_PaisesReaderResult The result
     */
    public function getEstados_Paises(int $estados_paisesId): Estados_PaisesReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $estados_paisesRow = $this->repository->getEstados_PaisesById($estados_paisesId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new Estados_PaisesReaderResult();
        $result->id = $estados_paisesRow['id'];
        $result->estado_pais = $estados_paisesRow['estado_pais'];
        
        return $result;
    }
}
