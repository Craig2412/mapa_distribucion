<?php

namespace App\Domain\Roles\Service;

use App\Domain\Roles\Data\RolesFinderItem;
use App\Domain\Roles\Data\RolesFinderResult;
use App\Domain\Roles\Repository\RolesFinderRepository;

final class RolesFinder
{
    private RolesFinderRepository $repository;

    public function __construct(RolesFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findRoless(): RolesFinderResult
    {
        // Input validation
        // ...

        $roless = $this->repository->findRoless();

        return $this->createResult($roless);
    }

    private function createResult(array $rolesRows): RolesFinderResult
    {
        $result = new RolesFinderResult();

        foreach ($rolesRows as $rolesRow) {
            $roles = new RolesFinderItem();
            $roles->id = $rolesRow['id'];
            $roles->role = $rolesRow['role'];
            
            $result->roless[] = $roles;
        }

        return $result;
    }
}
