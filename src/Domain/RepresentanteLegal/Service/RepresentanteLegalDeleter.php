<?php

namespace App\Domain\RepresentanteLegal\Service;

use App\Domain\RepresentanteLegal\Repository\RepresentanteLegalRepository;

final class RepresentanteLegalDeleter
{
    private RepresentanteLegalRepository $repository;

    public function __construct(RepresentanteLegalRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteRepresentanteLegal(int $representanteLegalId): void
    {

        $this->repository->deleteRepresentanteLegalById($representanteLegalId);
    }
}
