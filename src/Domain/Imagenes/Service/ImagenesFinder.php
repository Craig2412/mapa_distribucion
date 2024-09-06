<?php

namespace App\Domain\Imagenes\Service;

use App\Domain\Imagenes\Data\ImagenesFinderItem;
use App\Domain\Imagenes\Data\ImagenesFinderResult;
use App\Domain\Imagenes\Repository\ImagenesFinderRepository;

final class ImagenesFinder
{
    private ImagenesFinderRepository $repository;

    public function __construct(ImagenesFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findImageness(int $id_mayorista): ImagenesFinderResult
    {
    
        $imageness = $this->repository->findImageness($id_mayorista);

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
