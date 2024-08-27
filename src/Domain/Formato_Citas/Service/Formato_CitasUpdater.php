<?php

namespace App\Domain\Formato_Citas\Service;

use App\Domain\Formato_Citas\Repository\Formato_CitasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class Formato_CitasUpdater
{
    private Formato_CitasRepository $repository;

    private Formato_CitasValidator $formato_citasValidator;

    private LoggerInterface $logger;

    public function __construct(
        Formato_CitasRepository $repository,
        Formato_CitasValidator $formato_citasValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->formato_citasValidator = $formato_citasValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('formato_citas_updater.log')
            ->createLogger();
    }

    public function updateFormato_Citas(int $formato_citasId, array $data): array
    {
        // Input validation
        $this->formato_citasValidator->validateFormato_CitasUpdate($formato_citasId, $data);

        // Update the row
        $values = $this->repository->updateFormato_Citas($formato_citasId, $data);
        // Logging
        $this->logger->info(sprintf('Formato_Citas updated successfully: %s', $formato_citasId));
        return $values;
    }
}
