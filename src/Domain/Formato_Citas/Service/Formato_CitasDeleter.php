<?php

namespace App\Domain\Formato_Citas\Service;

use App\Domain\Formato_Citas\Repository\Formato_CitasRepository;

final class Formato_CitasDeleter
{
    private Formato_CitasRepository $repository;

    public function __construct(Formato_CitasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteFormato_Citas(int $formato_citasId): void
    {

        $this->repository->deleteFormato_CitasById($formato_citasId);
    }
}
