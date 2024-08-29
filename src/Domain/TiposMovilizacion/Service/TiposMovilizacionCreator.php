<?php

namespace App\Domain\TiposMovilizacion\Service;

use App\Domain\TiposMovilizacion\Repository\TiposMovilizacionRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class TiposMovilizacionCreator
{
    private TiposMovilizacionRepository $repository;

    private TiposMovilizacionValidator $tiposMovilizacionValidator;

    private LoggerInterface $logger;

    public function __construct(
        TiposMovilizacionRepository $repository,
        TiposMovilizacionValidator $tiposMovilizacionValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->tiposMovilizacionValidator = $tiposMovilizacionValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('tiposMovilizacion_creator.log')
            ->createLogger();
    }

    public function createTiposMovilizacion(array $data): int
    {
        // Input validation
        $this->tiposMovilizacionValidator->validateTiposMovilizacion($data);

        // Insert tiposMovilizacion and get new tiposMovilizacion ID
        $tiposMovilizacionId = $this->repository->insertTiposMovilizacion($data);

        // Logging
        $this->logger->info(sprintf('TiposMovilizacion created successfully: %s', $tiposMovilizacionId));

        return $tiposMovilizacionId;
    }
}
