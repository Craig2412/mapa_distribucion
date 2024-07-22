<?php

namespace App\Domain\Roles\Service;

use App\Domain\Roles\Repository\RolesRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RolesUpdater
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
            ->addFileHandler('roles_updater.log')
            ->createLogger();
    }

    public function updateRoles(int $rolesId, array $data): string
    {
        // Input validation
        $this->rolesValidator->validateRolesUpdate($rolesId, $data);

        // Update the row
        $value = $this->repository->updateRoles($rolesId, $data);

        // Logging
        $this->logger->info(sprintf('Roles updated successfully: %s', $rolesId));

        return $value['role'];
    }
}
