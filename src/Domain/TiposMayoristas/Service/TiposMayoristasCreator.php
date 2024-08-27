<?php

namespace App\Domain\TiposMayoristas\Service;

use App\Domain\TiposMayoristas\Repository\TiposMayoristasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class TiposMayoristasCreator
{
    private TiposMayoristasRepository $repository;

    private TiposMayoristasValidator $tiposMayoristasValidator;

    private LoggerInterface $logger;

    public function __construct(
        TiposMayoristasRepository $repository,
        TiposMayoristasValidator $tiposMayoristasValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->tiposMayoristasValidator = $tiposMayoristasValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('tiposMayoristas_creator.log')
            ->createLogger();
    }

    public function createTiposMayoristas(array $data): int
    {
        // Input validation
        $this->tiposMayoristasValidator->validateTiposMayoristas($data);

        // Insert tiposMayoristas and get new tiposMayoristas ID
        $tiposMayoristasId = $this->repository->insertTiposMayoristas($data);

        // Logging
        $this->logger->info(sprintf('TiposMayoristas created successfully: %s', $tiposMayoristasId));

        return $tiposMayoristasId;
    }
}
