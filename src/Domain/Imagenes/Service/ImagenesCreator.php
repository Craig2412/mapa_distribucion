<?php

namespace App\Domain\Imagenes\Service;

use App\Domain\Imagenes\Repository\ImagenesRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class ImagenesCreator
{
    private ImagenesRepository $repository;

    private ImagenesValidator $imagenesValidator;

    private LoggerInterface $logger;

    public function __construct(
        ImagenesRepository $repository,
        ImagenesValidator $imagenesValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->imagenesValidator = $imagenesValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('imagenes_creator.log')
            ->createLogger();
    }

    public function createImagenes(array $data): int
    {
        // Input validation
        $this->imagenesValidator->validateImagenes($data);

        // Insert imagenes and get new imagenes ID
        $imagenesId = $this->repository->insertImagenes($data);


        // Logging
        $this->logger->info(sprintf('Imagenes created successfully: %s', $imagenesId));

        return $imagenesId;
    }
}
