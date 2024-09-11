<?php

namespace App\Domain\FormasMovilizacion\Service;

use App\Domain\FormasMovilizacion\Repository\FormasMovilizacionRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class FormasMovilizacionUpdater
{
    private FormasMovilizacionRepository $repository;

    private FormasMovilizacionValidatorUpdate $formasMovilizacionValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        FormasMovilizacionRepository $repository,
        FormasMovilizacionValidatorUpdate $formasMovilizacionValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->formasMovilizacionValidatorUpdate = $formasMovilizacionValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('formasMovilizacion_updater.log')
            ->createLogger();
    }

    public function updateFormasMovilizacion(int $formasMovilizacionId, array $data): array
    {
        // Input validation
        $this->formasMovilizacionValidatorUpdate->validateFormasMovilizacionUpdate($formasMovilizacionId, $data);

        // Update the row
        $values = $this->repository->updateFormasMovilizacion($formasMovilizacionId, $data);

        // Logging
        $this->logger->info(sprintf('FormasMovilizacion updated successfully: %s', $formasMovilizacionId));
        return $values;
    }
}
