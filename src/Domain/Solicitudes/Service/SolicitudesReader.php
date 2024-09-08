<?php

namespace App\Domain\Solicitudes\Service;

use App\Domain\Solicitudes\Data\SolicitudesReaderResult;
use App\Domain\Solicitudes\Repository\SolicitudesRepository;

/**
 * Service.
 */
final class SolicitudesReader
{
    private SolicitudesRepository $repository;

    /**
     * The constructor.
     *
     * @param SolicitudesRepository $repository The repository
     */
    public function __construct(SolicitudesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a solicitudes.
     *
     * @param int $solicitudesId The solicitudes id
     *
     * @return SolicitudesReaderResult The result
     */
    public function getSolicitudes(int $solicitudesId): SolicitudesReaderResult
    {
              // Input validation
        // ...

        // Fetch data from the database
        $solicitudesRow = $this->repository->getSolicitudesById($solicitudesId);
       
        // Optional: Add or invoke your complex business logic here
        $result = new SolicitudesReaderResult();
        // Create domain result
        foreach ($solicitudesRow as $solicitudRows) {
            $sol = new SolicitudesReaderResult();
            $sol->id = $solicitudRows['id'];
            $sol->num_solicitud = $solicitudRows['num_solicitud'];
            $sol->num_registro = $solicitudRows['num_registro'];
            $sol->descripcion = $solicitudRows['descripcion'];
            $sol->respuesta = $solicitudRows['respuesta'];
            $sol->id_categoria = $solicitudRows['id_categoria'];
            $sol->categoria = $solicitudRows['categoria'];
            $sol->id_requerimiento = $solicitudRows['id_requerimiento'];
            $sol->id_condicion = $solicitudRows['id_condicion'];
            $sol->id_estado = $solicitudRows['id_estado'];
            $sol->estado = $solicitudRows['estado'];
            $sol->created = $solicitudRows['created'];
            $sol->updated = $solicitudRows['updated'];
            
            $result->solicitudes[] = $sol;
        }
        return $result;
    }
}
