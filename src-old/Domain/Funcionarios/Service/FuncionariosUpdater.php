<?php

namespace App\Domain\Funcionarios\Service;

use App\Domain\Funcionarios\Repository\FuncionariosRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class FuncionariosUpdater
{
    private FuncionariosRepository $repository;

    private FuncionariosValidatorUpdate $funcionariosValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        FuncionariosRepository $repository,
        FuncionariosValidatorUpdate $funcionariosValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->funcionariosValidatorUpdate = $funcionariosValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('funcionarios_updater.log')
            ->createLogger();
    }

    public function updateFuncionarios(int $funcionariosId, array $data): array
    {
        // Input validation
        $this->funcionariosValidatorUpdate->validateFuncionariosUpdate($funcionariosId, $data);

        // Update the row
        $values = $this->repository->updateFuncionarios($funcionariosId, $data);

        // Logging
        $this->logger->info(sprintf('Funcionarios updated successfully: %s', $funcionariosId));
        return $values;
    }
}
