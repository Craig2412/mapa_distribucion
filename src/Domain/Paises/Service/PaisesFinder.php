<?php

namespace App\Domain\Paises\Service;

use App\Domain\Paises\Data\PaisesFinderItem;
use App\Domain\Paises\Data\PaisesFinderResult;
use App\Domain\Paises\Repository\PaisesFinderRepository;

final class PaisesFinder
{
    private PaisesFinderRepository $repository;

    public function __construct(PaisesFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findPaisess(): PaisesFinderResult
    {
        // Input validation
        // ...

        $paisess = $this->repository->findPaisess();

        return $this->createResult($paisess);
    }

    private function createResult(array $paisesRows): PaisesFinderResult
    {
        $result = new PaisesFinderResult();

        foreach ($paisesRows as $paisesRow) {
            $paises = new PaisesFinderItem();
            $paises->id = $paisesRow['id'];
            $paises->pais = $paisesRow['pais'];
           
            $result->paisess[] = $paises;
        }

        return $result;
    }
}
