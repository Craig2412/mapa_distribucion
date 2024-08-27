<?php

namespace App\Domain\Cita\Service;

use App\Domain\Cita\Data\CitaReaderResult;
use App\Domain\Cita\Repository\CitaRepository;

/**
 * Service.
 */
final class CitabyRequerimientoReader
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
     * Read a citasbyRequerimiento.
     *
     * @param int $citasbyRequerimientoId The citasbyRequerimiento id
     *
     * @return CitaReaderResult The result
     */
    public function getCitabyRequerimiento(int $citasbyRequerimientoId): CitaReaderResult
    {
        // Input validation 
        // ...

        // Fetch data from the database
        $citasbyRequerimientoRow = $this->repository->getCitabyRequerimientoById($citasbyRequerimientoId);

        // Optional: Add or invoke your complex business logic here
        // ...
        // Create domain result
        $result = new CitaReaderResult();
        $result->id = $citasbyRequerimientoRow['id'];
        $result->fecha_cita = $citasbyRequerimientoRow['fecha_cita'];
        $result->id_requerimiento = $citasbyRequerimientoRow['id_requerimiento'];
        $result->estado = $citasbyRequerimientoRow['estado'];
        $result->id_estado = $citasbyRequerimientoRow['id_estado'];
        $result->id_formato_cita = $citasbyRequerimientoRow['id_formato_cita'];
        $result->id_condicion = $citasbyRequerimientoRow['id_condicion'];
        $result->formato_citas = $citasbyRequerimientoRow['formato_cita'];
        $result->created = $citasbyRequerimientoRow['created'];
        $result->updated = $citasbyRequerimientoRow['updated'];

        return $result;
    }
}
