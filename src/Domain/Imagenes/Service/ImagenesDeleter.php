<?php

namespace App\Domain\Imagenes\Service;

use App\Domain\Imagenes\Repository\ImagenesRepository;

final class ImagenesDeleter
{
    private ImagenesRepository $repository;

    public function __construct(ImagenesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteImagenes(int $imagenesId): void
    {

        $this->repository->deleteImagenesById($imagenesId);
    }
}
