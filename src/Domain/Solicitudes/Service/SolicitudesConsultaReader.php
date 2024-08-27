<?php

namespace App\Domain\Solicitudes\Service;

use App\Domain\Solicitudes\Data\SolicitudesConsultaReaderResult;
use App\Domain\Solicitudes\Repository\SolicitudesConsultaRepository;
use App\Domain\Solicitudes\Repository\SolicitudesRepository;



final class SolicitudesConsultaReader
{
    private SolicitudesConsultaRepository $repository;
    private SolicitudesRepository $repositoryS;

    /**
     * The constructor.
     *
     * @param SolicitudesConsultaRepository $repository The repository
     */
    public function __construct(SolicitudesConsultaRepository $repository, SolicitudesRepository $repositoryS)
    {
        $this->repository = $repository;
        $this->repositoryS = $repositoryS;
    }

    /**
     * Read a solicitudesConsulta.
     *
     * @param int $solicitudesConsultaId The solicitudesConsulta id
     *
     * @return SolicitudesConsultaReaderResult The result
     */
    public function getSolicitudesConsulta(string $solicitudesConsultaId): SolicitudesConsultaReaderResult
    {
        // Input validation

        // Fetch data from the database
        $solicitudesConsultaRow = $this->repository->connectingSipi($solicitudesConsultaId);
        $solicitudesConsultaRow2 = $this->repositoryS->existsSolicitudesNum($solicitudesConsultaRow['solicitud']);
        // Create domain result
        if ($solicitudesConsultaRow != null) {
            $result = new SolicitudesConsultaReaderResult();
            $result->nombre = trim($solicitudesConsultaRow['nombre']);
            $result->categoria = $solicitudesConsultaRow['estatus'];
            $result->nombre_categoria = trim($solicitudesConsultaRow['nombre_categoria']);
            $result->nro_derecho = trim($solicitudesConsultaRow['poder']);
            $result->registro = trim($solicitudesConsultaRow['registro']);
            $result->solicitud = $solicitudesConsultaRow['solicitud'];
            return $result;
        }else {
            $result = new SolicitudesConsultaReaderResult();
            $result->nombre = null;
            $result->categoria = null;
            $result->nro_derecho = null;
            $result->registro = null;
            $result->solicitud = null;
            return $result;
        }
       
    }
}
