<?php

namespace App\Domain\Municipios\Service;

use App\Domain\Municipios\Data\MunicipiosReaderResult;
use App\Domain\Municipios\Repository\MunicipiosRepository;

/**
 * Service.
 */
final class MunicipiosReader
{
    private MunicipiosRepository $repository;

    /**
     * The constructor.
     *
     * @param MunicipiosRepository $repository The repository
     */
    public function __construct(MunicipiosRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a municipios.
     *
     * @param int $municipiosId The municipios id
     *
     * @return MunicipiosReaderResult The result
     */
    public function getMunicipios(int $municipiosId): MunicipiosReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $municipiosRow = $this->repository->getMunicipiosById($municipiosId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new MunicipiosReaderResult();
        $result->id = $municipiosRow['id'];
        $result->municipio = $municipiosRow['municipio'];
        
        return $result;
    }
}
