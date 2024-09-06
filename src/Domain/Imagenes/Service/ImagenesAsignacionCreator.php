<?php

namespace App\Domain\Imagenes\Service;

use App\Domain\Imagenes\Repository\ImagenesRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class ImagenesAsignacionCreator
{
    private ImagenesRepository $repository;

    private ImagenesAsignacionValidator $imagenesAsignacionValidator;

    private LoggerInterface $logger;

    public function __construct(
        ImagenesRepository $repository,
        ImagenesAsignacionValidator $imagenesAsignacionValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->imagenesAsignacionValidator = $imagenesAsignacionValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('imagenesAsignacion_creator.log')
            ->createLogger();
    }

    public function createImagenesAsignacion(array $data): int
    {
        // Input validation
        $this->imagenesAsignacionValidator->validateImagenesAsignacion($data);

        // Insert imagenesAsignacion and get new imagenesAsignacion ID
        $imagenesAsignacionId = $this->repository->insertImagenesAsignacion($data);

        // Logging
        $this->logger->info(sprintf('ImagenesAsignacion created successfully: %s', $imagenesAsignacionId));

        return $imagenesAsignacionId;
    }
}
