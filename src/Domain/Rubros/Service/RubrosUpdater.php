<?php

namespace App\Domain\Rubros\Service;

use App\Domain\Rubros\Repository\RubrosRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RubrosUpdater
{
    private RubrosRepository $repository;

    private RubrosValidatorUpdate $rubrosValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        RubrosRepository $repository,
        RubrosValidatorUpdate $rubrosValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->rubrosValidatorUpdate = $rubrosValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('rubros_updater.log')
            ->createLogger();
    }

    public function updateRubros(int $rubrosId, array $data): array
    {
        // Input validation
        $this->rubrosValidatorUpdate->validateRubrosUpdate($rubrosId, $data);

        // Update the row
        $values = $this->repository->updateRubros($rubrosId, $data);

        // Logging
        $this->logger->info(sprintf('Rubros updated successfully: %s', $rubrosId));
        return $values;
    }
}
