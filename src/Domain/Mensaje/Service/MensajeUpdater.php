<?php

namespace App\Domain\Mensaje\Service;

use App\Domain\Mensaje\Repository\MensajeRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class MensajeUpdater
{
    private MensajeRepository $repositoryUpdate;

    private MensajeValidatorUpdate $mensajeValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        MensajeRepository $repositoryUpdate,
        MensajeValidatorUpdate $mensajeValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repositoryUpdate = $repositoryUpdate;
        $this->mensajeValidatorUpdate = $mensajeValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('mensaje_updater.log')
            ->createLogger();
    }

    public function updateMensaje(int $mensajeId, array $data): array
    {

        // Input validation
        $this->mensajeValidatorUpdate->validateMensajeUpdate($mensajeId, $data);

        // Update the row
        $var = $this->repositoryUpdate->updateMensaje($mensajeId, $data);
        

        // Logging
        $this->logger->info(sprintf('Mensaje updated successfully: %s', $mensajeId));

        return $var;
    }
}
