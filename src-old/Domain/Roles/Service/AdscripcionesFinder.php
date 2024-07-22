<?php

namespace App\Domain\Roles\Service;

use App\Domain\Roles\Data\AdscripcionesFinderItem;
use App\Domain\Roles\Data\AdscripcionesFinderResult;
use App\Domain\Roles\Repository\AdscripcionesFinderRepository;

final class AdscripcionesFinder
{
    private AdscripcionesFinderRepository $repository;

    public function __construct(AdscripcionesFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findAdscripcioness($id_rol,$ente): AdscripcionesFinderResult
    {
        // Input validation
        // ...

        $adscripcioness = $this->repository->findAdscripcioness($id_rol,$ente);

        return $this->createResult($adscripcioness);
    }

    private function createResult(array $adscripcionesRows): AdscripcionesFinderResult
    {
        $result = new AdscripcionesFinderResult();

        foreach ($adscripcionesRows as $adscripcionesRow) {
            $adscripciones = new AdscripcionesFinderItem();
            $adscripciones->id = $adscripcionesRow['id'];
            $adscripciones->ente = $adscripcionesRow['ente'];
            $adscripciones->ente_principal = $adscripcionesRow['role'];
            
            $result->adscripcioness[] = $adscripciones;
        }

        return $result;
    }
}
