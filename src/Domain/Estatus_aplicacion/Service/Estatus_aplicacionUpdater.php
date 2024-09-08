<?php

namespace App\Domain\Estatus_aplicacion\Service;

use App\Domain\Estatus_aplicacion\Repository\Estatus_aplicacionRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class Estatus_aplicacionUpdater
{
    private Estatus_aplicacionRepository $repository;

    private Estatus_aplicacionValidator $estatus_aplicacionValidator;

    private LoggerInterface $logger;

    public function __construct(
        Estatus_aplicacionRepository $repository,
        Estatus_aplicacionValidator $estatus_aplicacionValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->estatus_aplicacionValidator = $estatus_aplicacionValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('estatus_aplicacion_updater.log')
            ->createLogger();
    }

    public function updateEstatus_aplicacion(int $estatus_aplicacionId, array $data): array
    {
        // Input validation
        $this->estatus_aplicacionValidator->validateEstatus_aplicacionUpdate($estatus_aplicacionId, $data);

        // Update the row
        $values = $this->repository->updateEstatus_aplicacion($estatus_aplicacionId, $data);

        // Logging
        $this->logger->info(sprintf('Estatus_aplicacion updated successfully: %s', $estatus_aplicacionId));
        return $values;
    }
}
