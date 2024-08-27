<?php

namespace App\Domain\Areas\Service;

use App\Domain\Areas\Data\AreasReaderResult;
use App\Domain\Areas\Repository\AreasRepository;

/**
 * Service.
 */
final class AreasReader
{
    private AreasRepository $repository;

    /**
     * The constructor.
     *
     * @param AreasRepository $repository The repository
     */
    public function __construct(AreasRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a area.
     *
     * @param int $areaId The area id
     *
     * @return AreasReaderResult The result
     */
    public function getAreas(int $areaId): AreasReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $areaRow = $this->repository->getAreasById($areaId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new AreasReaderResult();
        $result->id = $areaRow['id'];
        $result->area = $areaRow['area'];
        
        return $result;
    }
}