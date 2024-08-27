<?php

namespace App\Domain\Categorias\Service;

use App\Domain\Categorias\Repository\CategoriasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class CategoriasUpdater
{
    private CategoriasRepository $repository;

    private CategoriasValidatorUpdate $categoriasValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        CategoriasRepository $repository,
        CategoriasValidatorUpdate $categoriasValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->categoriasValidatorUpdate = $categoriasValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('categorias_updater.log')
            ->createLogger();
    }

    public function updateCategorias(int $categoriasId, array $data): array
    {
        // Input validation
        $this->categoriasValidatorUpdate->validateCategoriasUpdate($categoriasId, $data);

        // Update the row
        $var = $this->repository->updateCategorias($categoriasId, $data);
        

        // Logging
        $this->logger->info(sprintf('Categorias updated successfully: %s', $categoriasId));

        return $var;
    }
}
