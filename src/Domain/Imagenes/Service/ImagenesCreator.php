<?php

namespace App\Domain\Rubros\Service;

use App\Domain\Rubros\Repository\RubrosRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RubrosCreator
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
            ->addFileHandler('rubros_creator.log')
            ->createLogger();
    }

    public function createRubros(array $data): int
    {
        // Input validation
        $this->rubrosValidator->validateRubros($data);

        // Insert rubros and get new rubros ID
        $rubrosId = $this->repository->insertRubros($data);

        // Logging
        $this->logger->info(sprintf('Rubros created successfully: %s', $rubrosId));

        return $rubrosId;
    }
}
