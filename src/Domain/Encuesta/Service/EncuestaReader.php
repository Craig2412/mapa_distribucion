<?php

namespace App\Domain\Encuesta\Service;

use App\Domain\Encuesta\Data\EncuestaReaderResult;
use App\Domain\Encuesta\Repository\EncuestaRepository;

/**
 * Service.
 */
final class EncuestaReader
{
    private EncuestaRepository $repository;

    /**
     * The constructor.
     *
     * @param EncuestaRepository $repository The repository
     */
    public function __construct(EncuestaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a encuestas.
     *
     * @param int $encuestasId The encuestas id
     *
     * @return EncuestaReaderResult The result
     */
    public function getEncuesta(int $encuestasId): EncuestaReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $encuestasRow = $this->repository->getEncuestaById($encuestasId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new EncuestaReaderResult();
        $result->id = $encuestasRow['id'];
        $result->encuestas = $encuestasRow['encuestas'];
        
        return $result;
    }
}
