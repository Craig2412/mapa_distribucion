<?php

namespace App\Domain\Estados\Service;

use App\Domain\Estados\Repository\EstadosRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class EstadosUpdater
{
    private EstadosRepository $repository;

    private EstadosValidator $estadosValidator;

    private LoggerInterface $logger;

    public function __construct(
        EstadosRepository $repository,
        EstadosValidator $estadosValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->estadosValidator = $estadosValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('estados_updater.log')
            ->createLogger();
    }

    public function updateEstados(int $estadosId, array $data): array
    {
        // Input validation
        $this->estadosValidator->validateEstadosUpdate($estadosId, $data);

        // Update the row
        $values = $this->repository->updateEstados($estadosId, $data);

        // Logging
        $this->logger->info(sprintf('Estados updated successfully: %s', $estadosId));
        return $values;
    }
}
