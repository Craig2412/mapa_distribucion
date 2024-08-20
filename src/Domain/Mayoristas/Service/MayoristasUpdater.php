<?php

namespace App\Domain\Mayoristas\Service;

use App\Domain\Mayoristas\Repository\MayoristasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class MayoristasUpdater
{
    private MayoristasRepository $repository;

    private MayoristasValidatorUpdate $mayoristasValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        MayoristasRepository $repository,
        MayoristasValidatorUpdate $mayoristasValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->mayoristasValidatorUpdate = $mayoristasValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('mayoristas_updater.log')
            ->createLogger();
    }

    public function updateMayoristas(int $mayoristasId, array $data, int $paso): array
    {
        // Input validation
        $this->mayoristasValidatorUpdate->validateMayoristasUpdate($mayoristasId, $data, $paso);

        // Update the row
        $values = $this->repository->updateMayoristas($mayoristasId, $data, $paso);

        // Logging
        $this->logger->info(sprintf('Mayoristas updated successfully: %s', $mayoristasId));
        return $values;
    }
}
