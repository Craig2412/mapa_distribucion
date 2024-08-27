<?php

namespace App\Domain\UsuariosBufetes\Service;

use App\Domain\UsuariosBufetes\Repository\UsuariosBufetesRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class UsuariosBufetesCreator
{
    private UsuariosBufetesRepository $repository;

    private UsuariosBufetesValidator $usuariosbufetesValidator;

    private LoggerInterface $logger;

    public function __construct(
        UsuariosBufetesRepository $repository,
        UsuariosBufetesValidator $usuariosbufetesValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->usuariosbufetesValidator = $usuariosbufetesValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('usuariosbufetes_creator.log')
            ->createLogger();
    }

    public function createUsuariosBufetes(array $data): int
    {
        // Input validation
        $this->usuariosbufetesValidator->validateUsuariosBufetes($data);

        // Insert usuariosbufetes and get new usuariosbufetes ID
        $usuariosbufetesId = $this->repository->insertUsuariosBufetes($data);

        // Logging
        $this->logger->info(sprintf('UsuariosBufetes created successfully: %s', $usuariosbufetesId));

        return $usuariosbufetesId;
    }
}
