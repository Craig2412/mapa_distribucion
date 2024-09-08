<?php

namespace App\Domain\Cargos\Service;

use App\Domain\Cargos\Repository\CargosRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class CargosCreator
{
    private CargosRepository $repository;

    private CargosValidator $cargosValidator;

    private LoggerInterface $logger;

    public function __construct(
        CargosRepository $repository,
        CargosValidator $cargosValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->cargosValidator = $cargosValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('cargos_creator.log')
            ->createLogger();
    }

    public function createCargos(array $data): int
    {
        // Input validation
        $this->cargosValidator->validateCargos($data);

        // Insert cargos and get new cargos ID
        $cargosId = $this->repository->insertCargos($data);

        // Logging
        $this->logger->info(sprintf('Cargos created successfully: %s', $cargosId));

        return $cargosId;
    }
}
