<?php

namespace App\Domain\Solicitudes\Service;

use App\Domain\Solicitudes\Data\SolicitudesFinderItem;
use App\Domain\Solicitudes\Data\SolicitudesFinderResult;
use App\Domain\Solicitudes\Repository\SolicitudesFinderRepository;

final class SolicitudesFinder
{
    private SolicitudesFinderRepository $repository;

    public function __construct(SolicitudesFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findSolicitudes(): SolicitudesFinderResult
    {
        // Input validation
        // ...

        $solicitudes = $this->repository->findSolicitudes();

        return $this->createResult($solicitudes);
    }

    private function createResult(array $solicitudRows): SolicitudesFinderResult
    {
        $result = new SolicitudesFinderResult();

        foreach ($solicitudRows as $solicitudRow) {
            $solicitud = new SolicitudesFinderItem();
            $solicitud->id = $solicitudRow['id'];
            $solicitud->num_solicitud = $solicitudRow['num_solicitud'];
            $solicitud->num_registro = $solicitudRow['num_registro'];
            $solicitud->descripcion = $solicitudRow['descripcion'];
            $solicitud->respuesta = $solicitudRow['respuesta'];
            $solicitud->id_categoria = $solicitudRow['id_categoria'];
            $solicitud->categoria = $solicitudRow['categoria'];
            $solicitud->id_requerimiento = $solicitudRow['id_requerimiento'];
            $solicitud->id_condicion = $solicitudRow['id_condicion'];
            $solicitud->id_estado = $solicitudRow['id_estado'];
            $solicitud->estado = $solicitudRow['estado'];
            $solicitud->created = $solicitudRow['created'];
            $solicitud->updated = $solicitudRow['updated'];

            $result->solicitudes[] = $solicitud;
        }
        return $result;
    }
}
