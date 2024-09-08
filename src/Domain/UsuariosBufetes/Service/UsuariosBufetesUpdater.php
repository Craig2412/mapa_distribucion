<?php

namespace App\Domain\UsuariosBufetes\Service;

use App\Domain\UsuariosBufetes\Repository\UsuariosBufetesRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class UsuariosBufetesUpdater
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
            ->addFileHandler('usuariosbufetes_updater.log')
            ->createLogger();
    }

    public function updateUsuariosBufetes(int $usuariosbufetesId, array $data): array
    {
        // Input validation
        $this->usuariosbufetesValidator->validateUsuariosBufetesUpdate($usuariosbufetesId, $data);

        // Update the row
        $var = $this->repository->updateUsuariosBufetes($usuariosbufetesId, $data);
        

        // Logging
        $this->logger->info(sprintf('UsuariosBufetes updated successfully: %s', $usuariosbufetesId));

        return $var;
    }
}
