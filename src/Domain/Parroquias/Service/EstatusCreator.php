<?php

namespace App\Domain\Estatus\Service;

use App\Domain\Estatus\Repository\EstatusRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class EstatusCreator
{
    private EstatusRepository $repository;

    private EstatusValidator $estatusValidator;

    private LoggerInterface $logger;

    public function __construct(
        EstatusRepository $repository,
        EstatusValidator $estatusValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->estatusValidator = $estatusValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('estatus_creator.log')
            ->createLogger();
    }

    public function createEstatus(array $data): int
    {
        // Input validation
        $this->estatusValidator->validateEstatus($data);

        // Insert estatus and get new estatus ID
        $estatusId = $this->repository->insertEstatus($data);

        // Logging
        $this->logger->info(sprintf('Estatus created successfully: %s', $estatusId));

        return $estatusId;
    }
}
