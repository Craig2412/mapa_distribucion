<?php

namespace App\Domain\Empresas\Service;

use App\Domain\Empresas\Repository\EmpresasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class EmpresasCreator
{
    private EmpresasRepository $repository;

    private EmpresasValidator $empresasValidator;

    private LoggerInterface $logger;

    public function __construct(
        EmpresasRepository $repository,
        EmpresasValidator $empresasValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->empresasValidator = $empresasValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('empresas_creator.log')
            ->createLogger();
    }

    public function createEmpresas(array $data): int
    {
        // Input validation
        $this->empresasValidator->validateEmpresas($data);

        // Insert empresas and get new empresas ID
        $empresasId = $this->repository->insertEmpresas($data);

        // Logging
        $this->logger->info(sprintf('Empresas created successfully: %s', $empresasId));

        return $empresasId;
    }
}
