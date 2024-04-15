<?php

namespace App\Domain\Usuario\Service;

use App\Domain\Usuario\Repository\UsuarioRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class UsuarioCreator
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
            ->addFileHandler('usuario_creator.log')
            ->createLogger();
    }

    public function createUsuario(array $data): int
    {
        // Input validation
            $this->usuarioValidator->validateUsuario($data);
        
        // Insert usuario and get new usuario ID
            $usuarioId = $this->repository->insertUsuario($data);

        // Logging
        $this->logger->info(sprintf('Usuario created successfully: %s', $usuarioId));

        return $usuarioId;
    }
}
