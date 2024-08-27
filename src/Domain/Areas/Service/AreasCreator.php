<?php

namespace App\Domain\Areas\Service;

use App\Domain\Areas\Repository\AreasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class AreasCreator
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
            ->addFileHandler('areas_creator.log')
            ->createLogger();
    }

    public function createAreas(array $data): int
    {
        // Input validation
        $this->areasValidator->validateAreas($data);

        // Insert areas and get new areas ID
        $areasId = $this->repository->insertAreas($data);

        // Logging
        $this->logger->info(sprintf('Areas created successfully: %s', $areasId));

        return $areasId;
    }
}
