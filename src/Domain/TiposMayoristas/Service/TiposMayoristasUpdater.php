<?php

namespace App\Domain\TiposMayoristas\Service;

use App\Domain\TiposMayoristas\Repository\TiposMayoristasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class TiposMayoristasUpdater
{
    private TiposMayoristasRepository $repository;

    private TiposMayoristasValidatorUpdate $tiposMayoristasValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        TiposMayoristasRepository $repository,
        TiposMayoristasValidatorUpdate $tiposMayoristasValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->tiposMayoristasValidatorUpdate = $tiposMayoristasValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('tiposMayoristas_updater.log')
            ->createLogger();
    }

    public function updateTiposMayoristas(int $tiposMayoristasId, array $data): array
    {
        // Input validation
        $this->tiposMayoristasValidatorUpdate->validateTiposMayoristasUpdate($tiposMayoristasId, $data);

        // Update the row
        $values = $this->repository->updateTiposMayoristas($tiposMayoristasId, $data);

        // Logging
        $this->logger->info(sprintf('TiposMayoristas updated successfully: %s', $tiposMayoristasId));
        return $values;
    }
}
