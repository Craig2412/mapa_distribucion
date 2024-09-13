<?php

namespace App\Domain\RubrosOrigen\Service;

use App\Domain\RubrosOrigen\Repository\RubrosOrigenRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RubrosOrigenUpdater
{
    private RubrosOrigenRepository $repository;

    private RubrosOrigenValidatorUpdate $rubrosOrigenValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        RubrosOrigenRepository $repository,
        RubrosOrigenValidatorUpdate $rubrosOrigenValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->rubrosOrigenValidatorUpdate = $rubrosOrigenValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('rubrosOrigen_updater.log')
            ->createLogger();
    }

    public function updateRubrosOrigen(int $rubrosOrigenId, array $data): array
    {
        // Input validation
        $this->rubrosOrigenValidatorUpdate->validateRubrosOrigenUpdate($rubrosOrigenId, $data);

        // Update the row
        $values = $this->repository->updateRubrosOrigen($rubrosOrigenId, $data);

        // Logging
        $this->logger->info(sprintf('RubrosOrigen updated successfully: %s', $rubrosOrigenId));
        return $values;
    }
}
