<?php

namespace App\Domain\Solicitudes\Service;

use App\Domain\Solicitudes\Data\SolicitudesbyCategoriasFinderItem;
use App\Domain\Solicitudes\Data\SolicitudesbyCategoriasFinderResult;
use App\Domain\Solicitudes\Repository\SolicitudesbyCategoriasFinderRepository;

final class SolicitudesbyCategoriasFinder
{
    private SolicitudesbyCategoriasFinderRepository $repository;

    public function __construct(SolicitudesbyCategoriasFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findSolicitudesbyCategorias(): SolicitudesbyCategoriasFinderResult
    {
        // Input validation
        $solicitudesbyCategorias = $this->repository->findSolicitudesbyCategorias();

        return $this->createResult($solicitudesbyCategorias);
    }

    private function createResult(array $solicitudesbyCategoriasRows): SolicitudesbyCategoriasFinderResult
    {
        $result = new SolicitudesbyCategoriasFinderResult();
        
        foreach ($solicitudesbyCategoriasRows as $solicitudesbyCategoriasRow) {
            $solicitudesbyCategorias = new SolicitudesbyCategoriasFinderItem();
           
            $solicitudesbyCategorias->categoria = $solicitudesbyCategoriasRow['estado'];
            $solicitudesbyCategorias->total = $solicitudesbyCategoriasRow['total'];

            $result->solicitudesbyCategorias[] = $solicitudesbyCategorias;
        }
        
        return $result;
    }
}
