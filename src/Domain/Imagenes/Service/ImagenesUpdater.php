<?php

namespace App\Domain\Imagenes\Service;

use App\Domain\Imagenes\Repository\ImagenesRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class ImagenesUpdater
{
    private ImagenesRepository $repository;

    private ImagenesValidatorUpdate $imagenesValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        ImagenesRepository $repository,
        ImagenesValidatorUpdate $imagenesValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->imagenesValidatorUpdate = $imagenesValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('imagenes_updater.log')
            ->createLogger();
    }

    public function updateImagenes(int $imagenesId, array $data): array
    {
        // Input validation
        $this->imagenesValidatorUpdate->validateImagenesUpdate($imagenesId, $data);

        // Update the row
        $values = $this->repository->updateImagenes($imagenesId, $data);

        // Logging
        $this->logger->info(sprintf('Imagenes updated successfully: %s', $imagenesId));
        return $values;
    }
}
