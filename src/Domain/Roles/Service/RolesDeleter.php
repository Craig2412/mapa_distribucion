<?php

namespace App\Domain\Roles\Service;

use App\Domain\Roles\Repository\RolesRepository;

final class RolesDeleter
{
    private RolesRepository $repository;

    public function __construct(RolesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteRoles(int $rolesId): void
    {
    
        $this->repository->deleteRolesById($rolesId);
    }
}
