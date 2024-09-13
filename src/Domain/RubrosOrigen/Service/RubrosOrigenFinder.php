<?php

namespace App\Domain\RubrosOrigen\Service;

use App\Domain\RubrosOrigen\Data\RubrosOrigenFinderItem;
use App\Domain\RubrosOrigen\Data\RubrosOrigenFinderResult;
use App\Domain\RubrosOrigen\Repository\RubrosOrigenFinderRepository;

final class RubrosOrigenFinder
{
    private RubrosOrigenFinderRepository $repository;

    public function __construct(RubrosOrigenFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findRubrosOrigens(): RubrosOrigenFinderResult
    {
        // Input validation
        // ...

        $rubrosOrigens = $this->repository->findRubrosOrigens();

        return $this->createResult($rubrosOrigens);
    }

    private function createResult(array $rubrosOrigenRows): RubrosOrigenFinderResult
    {
        $result = new RubrosOrigenFinderResult();

        foreach ($rubrosOrigenRows as $rubrosOrigenRow) {
            $rubrosOrigen = new RubrosOrigenFinderItem();
            $rubrosOrigen->id = $rubrosOrigenRow['id'];
            $rubrosOrigen->rubro = $rubrosOrigenRow['rubro'];
            $rubrosOrigen->presentacion = $rubrosOrigenRow['presentacion'];
            $rubrosOrigen->precio_ves = $rubrosOrigenRow['precio_ves'];
            $rubrosOrigen->precio_ptr = $rubrosOrigenRow['precio_ptr'];
            

            $result->rubrosOrigens[] = $rubrosOrigen;
        }

        return $result;
    }
}
