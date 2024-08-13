<?php

namespace App\Domain\Rubros\Service;

use App\Domain\Rubros\Repository\RubrosRepository;

final class RubrosDeleter
{
    private RubrosRepository $repository;

    public function __construct(RubrosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteRubros(int $rubrosId): void
    {

        $this->repository->deleteRubrosById($rubrosId);
    }
}
