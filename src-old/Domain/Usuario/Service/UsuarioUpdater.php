<?php

namespace App\Domain\Usuario\Service;

use App\Domain\Usuario\Repository\UsuarioRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class UsuarioUpdater
{
    private UsuarioRepository $repository;

    private UsuarioValidator $usuarioValidator;

    private LoggerInterface $logger;

    public function __construct(
        UsuarioRepository $repository,
        UsuarioValidator $usuarioValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->usuarioValidator = $usuarioValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('usuario_updater.log')
            ->createLogger();
    }

    public function updateUsuario(int $usuarioId, array $data): array
    {
        // Input validation
        $this->usuarioValidator->validateUsuarioUpdate($usuarioId, $data);

        // Update the row
        $values = $this->repository->updateUsuario($usuarioId, $data);

        // Logging
        $this->logger->info(sprintf('Usuario updated successfully: %s', $usuarioId));
        return $values;
    }
}
