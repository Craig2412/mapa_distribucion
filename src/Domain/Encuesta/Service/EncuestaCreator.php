<?php

namespace App\Domain\Encuesta\Service;

use App\Domain\Encuesta\Repository\EncuestaRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class EncuestaCreator
{
    private EncuestaRepository $repository;

    private EncuestaValidator $encuestaValidator;

    private LoggerInterface $logger;

    public function __construct(
        EncuestaRepository $repository,
        EncuestaValidator $encuestaValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->encuestaValidator = $encuestaValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('encuesta_creator.log')
            ->createLogger();
    }

    public function createEncuesta(array $data): array
    {
        $id_insertados =[];

        for ($i=0; $i < count($data); $i++) { 

            // Input validation
            $this->encuestaValidator->validateEncuesta($data[$i]);
    
            // Insert encuesta and get new encuesta ID
            $encuestaId = $this->repository->insertEncuesta($data[$i]);

            array_push($id_insertados, $encuestaId);
        }

        // Logging
        $this->logger->info(sprintf('Encuesta created successfully: %s', $id_insertados));

        return $id_insertados;
    }
}
