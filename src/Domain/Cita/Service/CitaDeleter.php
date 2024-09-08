<?php

namespace App\Domain\Cita\Service;

use App\Domain\Cita\Repository\CitaRepository;

final class CitaDeleter
{
    private CitaRepository $repository;

    public function __construct(CitaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteCita(int $citaId): void
    {
        $this->repository->deleteCitaById($citaId);
    }
}
