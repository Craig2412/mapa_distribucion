<?php

namespace App\Domain\Areas\Service;

use App\Domain\Areas\Repository\AreasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class AreasUpdater
{
    private AreasRepository $repository;

    private AreasValidator $areasValidator;

    private LoggerInterface $logger;

    public function __construct(
        AreasRepository $repository,
        AreasValidator $areasValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->areasValidator = $areasValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('areas_updater.log')
            ->createLogger();
    }

    public function updateAreas(int $areasId, array $data): array
    {
        // Input validation
        $this->areasValidator->validateAreasUpdate($areasId, $data);

        // Update the row
        $var = $this->repository->updateAreas($areasId, $data);
        

        // Logging
        $this->logger->info(sprintf('Areas updated successfully: %s', $areasId));

        return $var;
    }
}
