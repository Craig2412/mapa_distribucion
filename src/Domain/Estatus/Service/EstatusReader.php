<?php

namespace App\Domain\Estatus\Service;

use App\Domain\Estatus\Data\EstatusReaderResult;
use App\Domain\Estatus\Repository\EstatusRepository;

/**
 * Service.
 */
final class EstatusReader
{
    private EstatusRepository $repository;

    /**
     * The constructor.
     *
     * @param EstatusRepository $repository The repository
     */
    public function __construct(EstatusRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a estatus.
     *
     * @param int $estatusId The estatus id
     *
     * @return EstatusReaderResult The result
     */
    public function getEstatus(int $estatusId): EstatusReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $estatusRow = $this->repository->getEstatusById($estatusId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new EstatusReaderResult();
        $result->id = $estatusRow['id'];
        $result->estatus = $estatusRow['estatus'];
        
        return $result;
    }
}
