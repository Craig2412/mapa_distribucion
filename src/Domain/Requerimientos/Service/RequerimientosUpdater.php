<?php

namespace App\Domain\Requerimientos\Service;

use App\Domain\Requerimientos\Repository\RequerimientosRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class RequerimientosUpdater
{
    private RequerimientosRepository $repository;

    private RequerimientosValidatorUpdate $requerimientosValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        RequerimientosRepository $repository,
        RequerimientosValidatorUpdate $requerimientosValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->requerimientosValidatorUpdate = $requerimientosValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('requerimientos_updater.log')
            ->createLogger();
    }

    public function updateRequerimientos(int $requerimientosId, array $data): array
    {
        // Input validation
        $this->requerimientosValidatorUpdate->validateRequerimientosUpdate($requerimientosId, $data);

        // Update the row
        $var = $this->repository->updateRequerimientos($requerimientosId, $data);
        

        // Logging
        $this->logger->info(sprintf('Requerimientos updated successfully: %s', $requerimientosId));

        return $var;
    }
}
