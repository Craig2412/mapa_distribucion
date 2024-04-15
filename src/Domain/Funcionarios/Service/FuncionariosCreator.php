<?php

namespace App\Domain\Funcionarios\Service;

use App\Domain\Funcionarios\Repository\FuncionariosRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class FuncionariosCreator
{
    private FuncionariosRepository $repository;

    private FuncionariosValidator $funcionariosValidator;

    private LoggerInterface $logger;

    public function __construct(
        FuncionariosRepository $repository,
        FuncionariosValidator $funcionariosValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->funcionariosValidator = $funcionariosValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('funcionarios_creator.log')
            ->createLogger();
    }

    public function createFuncionarios(array $data): int
    {
        // Input validation
        $this->funcionariosValidator->validateFuncionarios($data);

        // Insert funcionarios and get new funcionarios ID
        $funcionariosId = $this->repository->insertFuncionarios($data);

        // Logging
        $this->logger->info(sprintf('Funcionarios created successfully: %s', $funcionariosId));

        return $funcionariosId;
    }
}
