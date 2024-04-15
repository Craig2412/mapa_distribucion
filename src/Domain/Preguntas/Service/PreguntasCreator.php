<?php

namespace App\Domain\Preguntas\Service;

use App\Domain\Preguntas\Repository\PreguntasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class PreguntasCreator
{
    private PreguntasRepository $repository;

    private PreguntasValidator $preguntasValidator;

    private LoggerInterface $logger;

    public function __construct(
        PreguntasRepository $repository,
        PreguntasValidator $preguntasValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->preguntasValidator = $preguntasValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('preguntas_creator.log')
            ->createLogger();
    }

    public function createPreguntas(array $data): int
    {
        // Input validation
        $this->preguntasValidator->validatePreguntas($data);

        // Insert preguntas and get new preguntas ID
        $preguntasId = $this->repository->insertPreguntas($data);

        // Logging
        $this->logger->info(sprintf('Preguntas created successfully: %s', $preguntasId));

        return $preguntasId;
    }
}
