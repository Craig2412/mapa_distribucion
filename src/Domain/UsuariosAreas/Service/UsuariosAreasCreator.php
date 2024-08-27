<?php

namespace App\Domain\UsuariosAreas\Service;

use App\Domain\UsuariosAreas\Repository\UsuariosAreasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class UsuariosAreasCreator
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
            ->addFileHandler('usuariosareas_creator.log')
            ->createLogger();
    }

    public function createUsuariosAreas(array $data): int
    {
        // Input validation
        $this->usuariosareasValidator->validateUsuariosAreas($data);

        // Insert usuariosareas and get new usuariosareas ID
        $usuariosareasId = $this->repository->insertUsuariosAreas($data);

        // Logging
        $this->logger->info(sprintf('UsuariosAreas created successfully: %s', $usuariosareasId));

        return $usuariosareasId;
    }
}
