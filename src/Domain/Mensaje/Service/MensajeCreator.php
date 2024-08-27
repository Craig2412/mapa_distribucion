<?php

namespace App\Domain\Mensaje\Service;

use App\Domain\Mensaje\Repository\MensajeRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class MensajeCreator
{
    private MensajeRepository $repository;

    private MensajeValidator $mensajeValidator;

    private LoggerInterface $logger;

    public function __construct(
        MensajeRepository $repository,
        MensajeValidator $mensajeValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->mensajeValidator = $mensajeValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('mensaje_creator.log')
            ->createLogger();
    }

    public function createMensaje(array $data): int
    {
        // Input validation
            $this->mensajeValidator->validateMensaje($data);
        
        // Insert mensaje and get new mensaje ID
            $mensajeId = $this->repository->insertMensaje($data);

        // Logging
        $this->logger->info(sprintf('Mensaje created successfully: %s', $mensajeId));

        return $mensajeId;
    }
}
