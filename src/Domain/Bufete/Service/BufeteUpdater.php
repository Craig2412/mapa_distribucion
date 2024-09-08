<?php

namespace App\Domain\Bufete\Service;

use App\Domain\Bufete\Repository\BufeteRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class BufeteUpdater
{
    private BufeteRepository $repositoryUpdate;

    private BufeteValidatorUpdate $bufeteValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        BufeteRepository $repositoryUpdate,
        BufeteValidatorUpdate $bufeteValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repositoryUpdate = $repositoryUpdate;
        $this->bufeteValidatorUpdate = $bufeteValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('bufete_updater.log')
            ->createLogger();
    }

    public function updateBufete(int $bufeteId, array $data): array
    {
        // Input validation
        $this->bufeteValidatorUpdate->validateBufeteUpdate($bufeteId, $data);

        // Update the row
        $var = $this->repositoryUpdate->updateBufete($bufeteId, $data);
        

        // Logging
        $this->logger->info(sprintf('Bufete updated successfully: %s', $bufeteId));

        return $var;
    }
}
