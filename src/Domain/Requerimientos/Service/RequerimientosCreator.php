<?php

namespace App\Domain\Requerimientos\Service;

use App\Domain\Requerimientos\Repository\RequerimientosRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RequerimientosCreator
{
    private RequerimientosRepository $repository;

    private RequerimientosValidator $requerimientosValidator;

    private LoggerInterface $logger;

    public function __construct(
        RequerimientosRepository $repository,
        RequerimientosValidator $requerimientosValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->requerimientosValidator = $requerimientosValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('requerimientos_creator.log')
            ->createLogger();
    }

    public function createRequerimientos(array $data): int
    {
        // Input validation
            $this->requerimientosValidator->validateRequerimientos($data);
        
        // Insert requerimientos and get new requerimientos ID
            $requerimientosId = $this->repository->insertRequerimientos($data);

        // Logging
        $this->logger->info(sprintf('Agent created successfully: %s', $requerimientosId));

        return $requerimientosId;
    }
}
