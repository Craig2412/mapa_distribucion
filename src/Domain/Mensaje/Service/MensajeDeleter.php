<?php

namespace App\Domain\Mensaje\Service;

use App\Domain\Mensaje\Repository\MensajeRepository;

final class MensajeDeleter
{
    private MensajeRepository $repository;

    public function __construct(MensajeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteMensaje(int $mensajeId): void
    {
        $this->repository->deleteMensajeById($mensajeId);
    }
}
