<?php

namespace App\Domain\Cita\Service;

use App\Domain\Cita\Data\CitaReaderResult;
use App\Domain\Cita\Repository\CitaRepository;

/**
 * Service.
 */
final class CitaReader
{
    private CitaRepository $repository;

    /**
     * The constructor.
     *
     * @param CitaRepository $repository The repository
     */
    public function __construct(CitaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a citas.
     *
     * @param int $citasId The citas id
     *
     * @return CitaReaderResult The result
     */
    public function getCita(int $citasId): CitaReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $citasRow = $this->repository->getCitaById($citasId);

        // Optional: Add or invoke your complex business logic here
        // ...
        // Create domain result
        $result = new CitaReaderResult();
        $result->id = $citasRow['id'];
        $result->fecha_cita = $citasRow['fecha_cita'];
        $result->id_requerimiento = $citasRow['id_requerimiento'];
        $result->estado = $citasRow['estado'];
        $result->id_estado = $citasRow['id_estado'];
        $result->id_formato_cita = $citasRow['id_formato_cita'];
        $result->id_condicion = $citasRow['id_condicion'];
        $result->formato_citas = $citasRow['formato_cita'];
        $result->created = $citasRow['created'];
        $result->updated = $citasRow['updated'];

        return $result;
    }
}
