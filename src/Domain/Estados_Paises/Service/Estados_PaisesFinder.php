<?php

namespace App\Domain\Estados_Paises\Service;

use App\Domain\Estados_Paises\Data\Estados_PaisesFinderItem;
use App\Domain\Estados_Paises\Data\Estados_PaisesFinderResult;
use App\Domain\Estados_Paises\Repository\Estados_PaisesFinderRepository;

final class Estados_PaisesFinder
{
    private Estados_PaisesFinderRepository $repository;

    public function __construct(Estados_PaisesFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findEstados_Paisess(): Estados_PaisesFinderResult
    {
        // Input validation
        // ...

        $estados_paisess = $this->repository->findEstados_Paisess();

        return $this->createResult($estados_paisess);
    }

    private function createResult(array $estados_paisesRows): Estados_PaisesFinderResult
    {
        $result = new Estados_PaisesFinderResult();

        foreach ($estados_paisesRows as $estados_paisesRow) {
            $estados_paises = new Estados_PaisesFinderItem();
            $estados_paises->id = $estados_paisesRow['id'];
            $estados_paises->estado_pais = $estados_paisesRow['estado_pais'];
           
            $result->estados_paisess[] = $estados_paises;
        }

        return $result;
    }
}
