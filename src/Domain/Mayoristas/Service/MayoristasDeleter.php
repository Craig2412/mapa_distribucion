<?php

namespace App\Domain\Mayoristas\Service;

use App\Domain\Mayoristas\Repository\MayoristasRepository;

final class MayoristasDeleter
{
    private MayoristasRepository $repository;

    public function __construct(MayoristasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteMayoristas(int $mayoristasId): void
    {

        $this->repository->deleteMayoristasById($mayoristasId);
    }
}
