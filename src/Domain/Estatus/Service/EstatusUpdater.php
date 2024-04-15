<?php

namespace App\Domain\Estatus\Service;

use App\Domain\Estatus\Repository\EstatusRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class EstatusUpdater
{
    private EstatusRepository $repository;

    private EstatusValidator $estatusValidator;

    private LoggerInterface $logger;

    public function __construct(
        EstatusRepository $repository,
        EstatusValidator $estatusValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->estatusValidator = $estatusValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('estatus_updater.log')
            ->createLogger();
    }

    public function updateEstatus(int $estatusId, array $data): array
    {
        // Input validation
        $this->estatusValidator->validateEstatusUpdate($estatusId, $data);

        // Update the row
        $values = $this->repository->updateEstatus($estatusId, $data);

        // Logging
        $this->logger->info(sprintf('Estatus updated successfully: %s', $estatusId));
        return $values;
    }
}
