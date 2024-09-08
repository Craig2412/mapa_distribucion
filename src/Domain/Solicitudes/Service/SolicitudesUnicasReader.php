<?php

namespace App\Domain\Solicitudes\Service;

use App\Domain\Solicitudes\Data\SolicitudesUnicasReaderResult;
use App\Domain\Solicitudes\Repository\SolicitudesUnicasRepository;



final class SolicitudesUnicasReader
{
    private SolicitudesUnicasRepository $repository;

    /**
     * The constructor.
     *
     * @param SolicitudesUnicasRepository $repository The repository
     */
    public function __construct(SolicitudesUnicasRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a solicitudesUnicas.
     *
     * @param int $solicitudesUnicasId The solicitudesUnicas id
     *
     * @return SolicitudesUnicasReaderResult The result
     */
    public function getSolicitudesUnicas(int $solicitudesUnicasId): SolicitudesUnicasReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $solicitudesUnicasRow = $this->repository->getSolicitudesUnicasById($solicitudesUnicasId);



        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new SolicitudesUnicasReaderResult();
       
        $result->id = $solicitudesUnicasRow[0]['id'];
        $result->num_solicitud = $solicitudesUnicasRow[0]['num_solicitud'];
        $result->num_registro = $solicitudesUnicasRow[0]['num_registro'];
        $result->descripcion = $solicitudesUnicasRow[0]['descripcion'];
        $result->respuesta = $solicitudesUnicasRow[0]['respuesta'];
        $result->id_categoria = $solicitudesUnicasRow[0]['id_categoria'];
        $result->categoria = $solicitudesUnicasRow[0]['categoria'];
        $result->id_requerimiento = $solicitudesUnicasRow[0]['id_requerimiento'];
        $result->id_condicion = $solicitudesUnicasRow[0]['id_condicion'];
        $result->id_estado = $solicitudesUnicasRow[0]['id_estado'];
        $result->estado = $solicitudesUnicasRow[0]['estado'];
        $result->created = $solicitudesUnicasRow[0]['created'];
        $result->updated = $solicitudesUnicasRow[0]['updated'];
        
        return $result;
    }
}
