<?php

namespace App\Domain\Solicitudes\Service;

use App\Domain\Solicitudes\Repository\SolicitudesRepository;

final class SolicitudesDeleter
{
    private SolicitudesRepository $repository;

    public function __construct(SolicitudesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteSolicitudes(int $solicitudesId): void
    {
        $this->repository->deleteSolicitudesById($solicitudesId);
    }
}
