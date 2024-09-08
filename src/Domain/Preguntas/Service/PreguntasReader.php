<?php

namespace App\Domain\Preguntas\Service;

use App\Domain\Preguntas\Data\PreguntasReaderResult;
use App\Domain\Preguntas\Repository\PreguntasRepository;

/**
 * Service.
 */
final class PreguntasReader
{
    private PreguntasRepository $repository;

    /**
     * The constructor.
     *
     * @param PreguntasRepository $repository The repository
     */
    public function __construct(PreguntasRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a preguntas.
     *
     * @param int $preguntasId The preguntas id
     *
     * @return PreguntasReaderResult The result
     */
    public function getPreguntas(int $preguntasId): PreguntasReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $preguntasRow = $this->repository->getPreguntasById($preguntasId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new PreguntasReaderResult();
        $result->id = $preguntasRow['id'];
        $result->pregunta = $preguntasRow['pregunta'];
        $result->etiqueta = $preguntasRow['etiqueta'];
        
        return $result;
    }
}
