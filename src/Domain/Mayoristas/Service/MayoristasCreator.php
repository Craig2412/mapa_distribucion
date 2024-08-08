<?php

namespace App\Domain\Mayoristas\Service;

use App\Domain\Mayoristas\Repository\MayoristasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class MayoristasCreator
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
            ->addFileHandler('mayoristas_creator.log')
            ->createLogger();
    }

    public function createMayoristas(array $data, int $paso): int
    {       
        // Input validation
        $this->mayoristasValidator->validateMayoristas($data,$paso);

        // Insert mayoristas and get new mayoristas ID
        $mayoristasId = $this->repository->insertMayoristas($data,$paso);

        // Logging
        $this->logger->info(sprintf('Mayoristas created successfully: %s', $mayoristasId));

        return $mayoristasId;
    }
}
