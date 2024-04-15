<?php

namespace App\Domain\Roles\Service;

use App\Domain\Roles\Repository\RolesRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RolesCreator
{
    private RolesRepository $repository;

    private RolesValidator $rolesValidator;

    private LoggerInterface $logger;

    public function __construct(
        RolesRepository $repository,
        RolesValidator $rolesValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->rolesValidator = $rolesValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('roles_creator.log')
            ->createLogger();
    }

    public function createRoles(array $data): int
    {
        // Input validation
        $this->rolesValidator->validateRoles($data);

        // Insert roles and get new roles ID
        $rolesId = $this->repository->insertRoles($data);

        // Logging
        $this->logger->info(sprintf('Roles created successfully: %s', $rolesId));

        return $rolesId;
    }
}
