<?php

namespace App\Domain\Areas\Service;

use App\Domain\Areas\Repository\AreasRepository;

final class AreasDeleter
{
    private AreasRepository $repository;

    public function __construct(AreasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteAreas(int $areasId): void
    {
        $this->repository->deleteAreasById($areasId);
    }
}
