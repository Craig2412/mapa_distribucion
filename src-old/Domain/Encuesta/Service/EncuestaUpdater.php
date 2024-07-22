<?php

namespace App\Domain\Encuesta\Service;

use App\Domain\Encuesta\Repository\EncuestaRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class EncuestaUpdater
{
    private EncuestaRepository $repository;

    private EncuestaValidator $encuestaValidator;

    private LoggerInterface $logger;

    public function __construct(
        EncuestaRepository $repository,
        EncuestaValidator $encuestaValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->encuestaValidator = $encuestaValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('encuesta_updater.log')
            ->createLogger();
    }

    public function updateEncuesta(int $encuestaId, array $data): array
    {
        // Input validation
        $this->encuestaValidator->validateEncuestaUpdate($encuestaId, $data);

        // Update the row
        $values = $this->repository->updateEncuesta($encuestaId, $data);

        // Logging
        $this->logger->info(sprintf('Encuesta updated successfully: %s', $encuestaId));
        return $values;
    }
}
