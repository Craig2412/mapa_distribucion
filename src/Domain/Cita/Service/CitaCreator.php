<?php

namespace App\Domain\Cita\Service;

use App\Domain\Cita\Repository\CitaRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class CitaCreator
{
    private CitaRepository $repository;

    private CitaValidator $citaValidator;

    private LoggerInterface $logger;

    public function __construct(
        CitaRepository $repository,
        CitaValidator $citaValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->citaValidator = $citaValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('cita_creator.log')
            ->createLogger();
    }

    
    
    
    
    public function createCita(array $data): int
    {
        // Input validation
        $this->citaValidator->validateCita($data);

        // Insert cita and get new cita ID
        $citaId = $this->repository->insertCitas($data);

        // Logging
        $this->logger->info(sprintf('Cita created successfully: %s', $citaId));

        return $citaId;
    }


}
