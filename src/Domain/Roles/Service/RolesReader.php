<?php

namespace App\Domain\Roles\Service;

use App\Domain\Roles\Data\RolesReaderResult;
use App\Domain\Roles\Repository\RolesRepository;

/**
 * Service.
 */
final class RolesReader
{
    private RolesRepository $repository;

    /**
     * The constructor.
     *
     * @param RolesRepository $repository The repository
     */
    public function __construct(RolesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a roles.
     *
     * @param int $rolesId The roles id
     *
     * @return RolesReaderResult The result
     */
    public function getRoles(int $rolesId): RolesReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $rolesRow = $this->repository->getRolesById($rolesId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new RolesReaderResult();
        $result->id = $rolesRow['id'];
        $result->role = $rolesRow['role'];

        return $result;
    }
}
