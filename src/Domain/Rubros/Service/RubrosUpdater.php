<?php

namespace App\Domain\Rubros\Service;

use App\Domain\Rubros\Repository\RubrosRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RubrosUpdater
{
    private RubrosRepository $repository;

    private RubrosValidator $rubrosValidator;

    private LoggerInterface $logger;

    public function __construct(
        RubrosRepository $repository,
        RubrosValidator $rubrosValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->rubrosValidator = $rubrosValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('rubros_updater.log')
            ->createLogger();
    }

    public function updateRubros(int $rubrosId, array $data): array
    {
        // Input validation
        $this->rubrosValidator->validateRubrosUpdate($rubrosId, $data);

        // Update the row
        $values = $this->repository->updateRubros($rubrosId, $data);

        // Logging
        $this->logger->info(sprintf('Rubros updated successfully: %s', $rubrosId));
        return $values;
    }
}
