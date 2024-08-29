<?php

namespace App\Domain\TiposMovilizacion\Service;

use App\Domain\TiposMovilizacion\Repository\TiposMovilizacionRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class TiposMovilizacionUpdater
{
    private TiposMovilizacionRepository $repository;

    private TiposMovilizacionValidatorUpdate $tiposMovilizacionValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        TiposMovilizacionRepository $repository,
        TiposMovilizacionValidatorUpdate $tiposMovilizacionValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->tiposMovilizacionValidatorUpdate = $tiposMovilizacionValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('tiposMovilizacion_updater.log')
            ->createLogger();
    }

    public function updateTiposMovilizacion(int $tiposMovilizacionId, array $data): array
    {
        // Input validation
        $this->tiposMovilizacionValidatorUpdate->validateTiposMovilizacionUpdate($tiposMovilizacionId, $data);

        // Update the row
        $values = $this->repository->updateTiposMovilizacion($tiposMovilizacionId, $data);

        // Logging
        $this->logger->info(sprintf('TiposMovilizacion updated successfully: %s', $tiposMovilizacionId));
        return $values;
    }
}
