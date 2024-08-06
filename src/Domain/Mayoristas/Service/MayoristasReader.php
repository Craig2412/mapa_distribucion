<?php

namespace App\Domain\Mayoristas\Service;

use App\Domain\Mayoristas\Data\MayoristasReaderResult;
use App\Domain\Mayoristas\Repository\MayoristasRepository;

/**
 * Service.
 */
final class MayoristasReader
{
    private MayoristasRepository $repository;

    /**
     * The constructor.
     *
     * @param MayoristasRepository $repository The repository
     */
    public function __construct(MayoristasRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a mayoristas.
     *
     * @param int $mayoristasId The mayoristas id
     *
     * @return MayoristasReaderResult The result
     */
    public function getMayoristas(int $mayoristasId): MayoristasReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $mayoristasRow = $this->repository->getMayoristasById($mayoristasId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new MayoristasReaderResult();
        $result->id = $mayoristasRow['id'];
        $result->mayoristas = $mayoristasRow['mayoristas'];
        
        return $result;
    }
}
