<?php

namespace App\Domain\Estados\Service;

use App\Domain\Estados\Repository\EstadosRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class EstadosCreator
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
            ->addFileHandler('estados_creator.log')
            ->createLogger();
    }

    public function createEstados(array $data): int
    {
        // Input validation
        $this->estadosValidator->validateEstados($data);

        // Insert estados and get new estados ID
        $estadosId = $this->repository->insertEstados($data);

        // Logging
        $this->logger->info(sprintf('Estados created successfully: %s', $estadosId));

        return $estadosId;
    }
}
