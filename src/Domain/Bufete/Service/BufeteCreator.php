<?php

namespace App\Domain\Bufete\Service;

use App\Domain\Bufete\Repository\BufeteRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class BufeteCreator
{
    private BufeteRepository $repository;

    private BufeteValidator $bufeteValidator;

    private LoggerInterface $logger;

    public function __construct(
        BufeteRepository $repository,
        BufeteValidator $bufeteValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->bufeteValidator = $bufeteValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('bufete_creator.log')
            ->createLogger();
    }

    public function createBufete(array $data): int
    {
        // Input validation
        $this->bufeteValidator->validateBufete($data);

        // Insert bufete and get new bufete ID
        $bufeteId = $this->repository->insertBufete($data);

        // Logging
        $this->logger->info(sprintf('Bufete created successfully: %s', $bufeteId));

        return $bufeteId;
    }
}
