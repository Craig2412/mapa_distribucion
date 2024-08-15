<?php

namespace App\Domain\RepresentanteLegal\Service;

use App\Domain\RepresentanteLegal\Data\RepresentanteLegalReaderResult;
use App\Domain\RepresentanteLegal\Repository\RepresentanteLegalRepository;

/**
 * Service.
 */
final class RepresentanteLegalReader
{
    private RepresentanteLegalRepository $repository;

    /**
     * The constructor.
     *
     * @param RepresentanteLegalRepository $repository The repository
     */
    public function __construct(RepresentanteLegalRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a representanteLegal.
     *
     * @param int $representanteLegalId The representanteLegal id
     *
     * @return RepresentanteLegalReaderResult The result
     */
    public function getRepresentanteLegal(int $representanteLegalId): RepresentanteLegalReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $representanteLegalRow = $this->repository->getRepresentanteLegalById($representanteLegalId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new RepresentanteLegalReaderResult();
        $result->id = $representanteLegalRow['id'];
        $result->nombres = $representanteLegalRow['nombres'];
        $result->apellidos = $representanteLegalRow['apellidos'];
        $result->identificacion = $representanteLegalRow['identificacion'];
        $result->correo = $representanteLegalRow['correo'];
        $result->telefono = $representanteLegalRow['telefono'];
        
        return $result;
    }
}
