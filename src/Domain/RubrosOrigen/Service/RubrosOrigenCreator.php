<?php

namespace App\Domain\RubrosOrigen\Service;

use App\Domain\RubrosOrigen\Repository\RubrosOrigenRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RubrosOrigenCreator
{
    private RubrosOrigenRepository $repository;

    private RubrosOrigenValidator $rubrosOrigenValidator;

    private LoggerInterface $logger;

    public function __construct(
        RubrosOrigenRepository $repository,
        RubrosOrigenValidator $rubrosOrigenValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->rubrosOrigenValidator = $rubrosOrigenValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('rubrosOrigen_creator.log')
            ->createLogger();
    }

    public function createRubrosOrigen(array $data): int
    {
        // Input validation
        $this->rubrosOrigenValidator->validateRubrosOrigen($data);

        // Insert rubrosOrigen and get new rubrosOrigen ID
        $rubrosOrigenId = $this->repository->insertRubrosOrigen($data);

        // Logging
        $this->logger->info(sprintf('RubrosOrigen created successfully: %s', $rubrosOrigenId));

        return $rubrosOrigenId;
    }
}
