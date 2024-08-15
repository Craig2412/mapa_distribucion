<?php

namespace App\Domain\RepresentanteLegal\Service;

use App\Domain\RepresentanteLegal\Repository\RepresentanteLegalRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RepresentanteLegalUpdater
{
    private RepresentanteLegalRepository $repository;

    private RepresentanteLegalValidatorUpdate $representanteLegalValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        RepresentanteLegalRepository $repository,
        RepresentanteLegalValidatorUpdate $representanteLegalValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->representanteLegalValidatorUpdate = $representanteLegalValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('representanteLegal_updater.log')
            ->createLogger();
    }

    public function updateRepresentanteLegal(int $representanteLegalId, array $data): array
    {
        // Input validation
        $this->representanteLegalValidatorUpdate->validateRepresentanteLegalUpdate($representanteLegalId, $data);

        // Update the row
        $values = $this->repository->updateRepresentanteLegal($representanteLegalId, $data);

        // Logging
        $this->logger->info(sprintf('RepresentanteLegal updated successfully: %s', $representanteLegalId));
        return $values;
    }
}
