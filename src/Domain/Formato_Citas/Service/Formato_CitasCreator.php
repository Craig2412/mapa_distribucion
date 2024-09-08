<?php

namespace App\Domain\Formato_Citas\Service;

use App\Domain\Formato_Citas\Repository\Formato_CitasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class Formato_CitasCreator
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
            ->addFileHandler('formato_citas_creator.log')
            ->createLogger();
    }

    public function createFormato_Citas(array $data): int
    {
        // Input validation
        $this->formato_citasValidator->validateFormato_Citas($data);

        // Insert formato_citas and get new formato_citas ID
        $formato_citasId = $this->repository->insertFormato_Citas($data);

        // Logging
        $this->logger->info(sprintf('Formato_Citas created successfully: %s', $formato_citasId));

        return $formato_citasId;
    }
}
