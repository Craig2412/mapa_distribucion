<?php

namespace App\Domain\Imagenes\Service;

use App\Domain\Imagenes\Data\ImagenesReaderResult;
use App\Domain\Imagenes\Data\ImagenesFinderItem;
use App\Domain\Imagenes\Data\ImagenesFinderResult;
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
    public function getImagenes(int $imagenesId): ImagenesFinderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $imageness = $this->repository->getImagenesById($imagenesId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        return $this->createResult($imageness);
    }

    private function createResult(array $imagenesRows): ImagenesFinderResult
    {
        $result = new ImagenesFinderResult();

        foreach ($imagenesRows as $imagenesRow) {
            $imagenes = new ImagenesFinderItem();
            $imagenes->id = $imagenesRow['id'];
            $imagenes->id_img = $imagenesRow['id_img'];
            $imagenes->url = $imagenesRow['url'];
            

            $result->imageness[] = $imagenes;
        }

        return $result;
    }
}


