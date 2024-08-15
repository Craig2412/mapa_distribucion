<?php

namespace App\Domain\RepresentanteLegal\Service;

use App\Domain\RepresentanteLegal\Repository\RepresentanteLegalRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RepresentanteLegalCreator
{
    private RepresentanteLegalRepository $repository;

    private RepresentanteLegalValidator $representanteLegalValidator;

    private LoggerInterface $logger;

    public function __construct(
        RepresentanteLegalRepository $repository,
        RepresentanteLegalValidator $representanteLegalValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->representanteLegalValidator = $representanteLegalValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('representanteLegal_creator.log')
            ->createLogger();
    }

    public function createRepresentanteLegal(array $data): int
    {
        // Input validation
        $this->representanteLegalValidator->validateRepresentanteLegal($data);

        // Insert representanteLegal and get new representanteLegal ID
        $representanteLegalId = $this->repository->insertRepresentanteLegal($data);

        // Logging
        $this->logger->info(sprintf('RepresentanteLegal created successfully: %s', $representanteLegalId));

        return $representanteLegalId;
    }
}
