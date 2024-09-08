<?php

namespace App\Domain\UsuariosAreas\Service;

use App\Domain\UsuariosAreas\Repository\UsuariosAreasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class UsuariosAreasUpdater
{
    private UsuariosAreasRepository $repository;

    private UsuariosAreasValidator $usuariosareasValidator;

    private LoggerInterface $logger;

    public function __construct(
        UsuariosAreasRepository $repository,
        UsuariosAreasValidator $usuariosareasValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->usuariosareasValidator = $usuariosareasValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('usuariosareas_updater.log')
            ->createLogger();
    }

    public function updateUsuariosAreas(int $usuariosareasId, array $data): array
    {
        // Input validation
        $this->usuariosareasValidator->validateUsuariosAreasUpdate($usuariosareasId, $data);

        // Update the row
        $var = $this->repository->updateUsuariosAreas($usuariosareasId, $data);
        

        // Logging
        $this->logger->info(sprintf('UsuariosAreas updated successfully: %s', $usuariosareasId));

        return $var;
    }
}
