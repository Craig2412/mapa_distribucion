<?php

namespace App\Domain\Permissions\Service;

use App\Domain\Permissions\Repository\PermissionsRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class PermissionsCreator
{
    private PermissionsRepository $repository;

    private PermissionsValidator $permissionsValidator;

    private LoggerInterface $logger;

    public function __construct(
        PermissionsRepository $repository,
        PermissionsValidator $permissionsValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->permissionsValidator = $permissionsValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('permissions_creator.log')
            ->createLogger();
    }

    public function createPermissions(array $data): int
    {
        // Input validation
        $this->permissionsValidator->validatePermissions($data);

        // Insert permissions and get new permissions ID
        $permissionsId = $this->repository->insertPermissions($data);

        // Logging
        $this->logger->info(sprintf('Permissions created successfully: %s', $permissionsId));

        return $permissionsId;
    }
}
