<?php

namespace App\Domain\Preguntas\Service;

use App\Domain\Preguntas\Repository\PreguntasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class PreguntasUpdater
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
            ->addFileHandler('preguntas_updater.log')
            ->createLogger();
    }

    public function updatePreguntas(int $preguntasId, array $data): array
    {
        // Input validation
        $this->preguntasValidator->validatePreguntasUpdate($preguntasId, $data);

        // Update the row
        $values = $this->repository->updatePreguntas($preguntasId, $data);

        // Logging
        $this->logger->info(sprintf('Preguntas updated successfully: %s', $preguntasId));
        return $values;
    }
}
