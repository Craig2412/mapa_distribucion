<?php

namespace App\Domain\Solicitudes\Service;

use App\Domain\Solicitudes\Repository\SolicitudesRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class SolicitudesUpdater
{
    private SolicitudesRepository $repository;

    private SolicitudesValidatorUpdate $solicitudesValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        SolicitudesRepository $repository,
        SolicitudesValidatorUpdate $solicitudesValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->solicitudesValidatorUpdate = $solicitudesValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('solicitudes_updater.log')
            ->createLogger();
    }

    public function updateSolicitudes(int $solicitudesId, array $data): array
    {
        // Input validation
        $this->solicitudesValidatorUpdate->validateSolicitudesUpdate($solicitudesId, $data);

        // Update the row
        $var = $this->repository->updateSolicitudes($solicitudesId, $data);
        

        // Logging
        $this->logger->info(sprintf('Solicitudes updated successfully: %s', $solicitudesId));

        return $var;
    }
}
