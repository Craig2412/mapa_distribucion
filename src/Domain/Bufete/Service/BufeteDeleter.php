<?php

namespace App\Domain\Bufete\Service;

use App\Domain\Bufete\Repository\BufeteRepository;

final class BufeteDeleter
{
    private BufeteRepository $repository;

    public function __construct(BufeteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteBufete(int $bufeteId): void
    {
        $this->repository->deleteBufeteById($bufeteId);
    }
}
