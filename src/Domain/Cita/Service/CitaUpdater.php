<?php

namespace App\Domain\Cita\Service;

use App\Domain\Cita\Repository\CitaRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class CitaUpdater
{
    private CitaRepository $repositoryUpdate;

    private CitaValidatorUpdate $citaValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        CitaRepository $repositoryUpdate,
        CitaValidatorUpdate $citaValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repositoryUpdate = $repositoryUpdate;
        $this->citaValidatorUpdate = $citaValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('cita_updater.log')
            ->createLogger();
    }

    public function updateCita(int $citaId, array $data): array
    {
        // Input validation
        $this->citaValidatorUpdate->validateCitaUpdate($citaId, $data);

        // Update the row
        $var = $this->repositoryUpdate->updateCita($citaId, $data);
        

        // Logging
        $this->logger->info(sprintf('Cita updated successfully: %s', $citaId));

        return $var;
    }
}
