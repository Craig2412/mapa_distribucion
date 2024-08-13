<?php

namespace App\Domain\Rubros\Service;

use App\Domain\Rubros\Data\RubrosFinderItem;
use App\Domain\Rubros\Data\RubrosFinderResult;
use App\Domain\Rubros\Repository\RubrosFinderRepository;

final class RubrosFinder
{
    private RubrosFinderRepository $repository;

    public function __construct(RubrosFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findRubross(): RubrosFinderResult
    {
        // Input validation
        // ...

        $rubross = $this->repository->findRubross();

        return $this->createResult($rubross);
    }

    private function createResult(array $rubrosRows): RubrosFinderResult
    {
        $result = new RubrosFinderResult();

        foreach ($rubrosRows as $rubrosRow) {
            $rubros = new RubrosFinderItem();
            $rubros->id = $rubrosRow['id'];
            $rubros->rubros = $rubrosRow['rubros'];
            

            $result->rubross[] = $rubros;
        }

        return $result;
    }
}
