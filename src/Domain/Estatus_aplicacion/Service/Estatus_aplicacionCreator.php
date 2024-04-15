<?php

namespace App\Domain\Estatus_aplicacion\Service;

use App\Domain\Estatus_aplicacion\Repository\Estatus_aplicacionRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class Estatus_aplicacionCreator
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
            ->addFileHandler('estatus_aplicacion_creator.log')
            ->createLogger();
    }

    public function createEstatus_aplicacion(array $data): int
    {
        // Input validation
        $this->estatus_aplicacionValidator->validateEstatus_aplicacion($data);

        // Insert estatus_aplicacion and get new estatus_aplicacion ID
        $estatus_aplicacionId = $this->repository->insertEstatus_aplicacion($data);

        // Logging
        $this->logger->info(sprintf('Estatus_aplicacion created successfully: %s', $estatus_aplicacionId));

        return $estatus_aplicacionId;
    }
}
