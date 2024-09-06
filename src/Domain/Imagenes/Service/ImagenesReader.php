<?php

namespace App\Domain\Imagenes\Service;

use App\Domain\Imagenes\Data\ImagenesReaderResult;
use App\Domain\Imagenes\Repository\ImagenesRepository;

/**
 * Service.
 */
final class ImagenesReader
{
    private ImagenesRepository $repository;

    /**
     * The constructor.
     *
     * @param ImagenesRepository $repository The repository
     */
    public function __construct(ImagenesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a imagenes.
     *
     * @param int $imagenesId The imagenes id
     *
     * @return ImagenesReaderResult The result
     */
    public function getImagenes(int $imagenesId): ImagenesReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $imagenesRow = $this->repository->getImagenesById($imagenesId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new ImagenesReaderResult();
        $result->id = $imagenesRow['id'];
        $result->url = $imagenesRow['url'];
        
        return $result;
    }
}
