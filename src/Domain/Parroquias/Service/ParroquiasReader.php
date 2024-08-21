<?php

namespace App\Domain\Parroquias\Service;

use App\Domain\Parroquias\Data\ParroquiasReaderResult;
use App\Domain\Parroquias\Repository\ParroquiasRepository;

/**
 * Service.
 */
final class ParroquiasReader
{
    private ParroquiasRepository $repository;

    /**
     * The constructor.
     *
     * @param ParroquiasRepository $repository The repository
     */
    public function __construct(ParroquiasRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a parroquias.
     *
     * @param int $parroquiasId The parroquias id
     *
     * @return ParroquiasReaderResult The result
     */
    public function getParroquias(int $parroquiasId): ParroquiasReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $parroquiasRow = $this->repository->getParroquiasById($parroquiasId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new ParroquiasReaderResult();
        $result->id = $parroquiasRow['id'];
        $result->parroquia = $parroquiasRow['parroquia'];
        
        return $result;
    }
}
