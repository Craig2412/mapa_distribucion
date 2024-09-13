<?php

namespace App\Domain\RubrosOrigen\Service;

use App\Domain\RubrosOrigen\Repository\RubrosOrigenRepository;

final class RubrosOrigenDeleter
{
    private RubrosOrigenRepository $repository;

    public function __construct(RubrosOrigenRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteRubrosOrigen(int $rubrosOrigenId): void
    {

        $this->repository->deleteRubrosOrigenById($rubrosOrigenId);
    }
}
