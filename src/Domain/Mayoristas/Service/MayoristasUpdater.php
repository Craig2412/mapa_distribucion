<?php

namespace App\Domain\Mayoristas\Service;

use App\Domain\Mayoristas\Repository\MayoristasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class MayoristasUpdater
{
    private MayoristasRepository $repository;

    private MayoristasValidator $mayoristasValidator;

    private LoggerInterface $logger;

    public function __construct(
        MayoristasRepository $repository,
        MayoristasValidator $mayoristasValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->mayoristasValidator = $mayoristasValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('mayoristas_updater.log')
            ->createLogger();
    }

    public function updateMayoristas(int $mayoristasId, array $data): array
    {
        // Input validation
        $this->mayoristasValidator->validateMayoristasUpdate($mayoristasId, $data);

        // Update the row
        $values = $this->repository->updateMayoristas($mayoristasId, $data);

        // Logging
        $this->logger->info(sprintf('Mayoristas updated successfully: %s', $mayoristasId));
        return $values;
    }
}
