<?php

namespace App\Domain\FormasMovilizacion\Service;

use App\Domain\FormasMovilizacion\Repository\FormasMovilizacionRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class FormasMovilizacionCreator
{
    private FormasMovilizacionRepository $repository;

    private FormasMovilizacionValidator $formasMovilizacionValidator;

    private LoggerInterface $logger;

    public function __construct(
        FormasMovilizacionRepository $repository,
        FormasMovilizacionValidator $formasMovilizacionValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->formasMovilizacionValidator = $formasMovilizacionValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('formasMovilizacion_creator.log')
            ->createLogger();
    }

    public function createFormasMovilizacion(array $data): int
    {
        // Input validation
        $this->formasMovilizacionValidator->validateFormasMovilizacion($data);

        // Insert formasMovilizacion and get new formasMovilizacion ID
        $formasMovilizacionId = $this->repository->insertFormasMovilizacion($data);

        // Logging
        $this->logger->info(sprintf('FormasMovilizacion created successfully: %s', $formasMovilizacionId));

        return $formasMovilizacionId;
    }
}
