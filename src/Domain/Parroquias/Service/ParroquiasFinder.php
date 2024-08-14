<?php

namespace App\Domain\Parroquias\Service;

use App\Domain\Parroquias\Data\ParroquiasFinderItem;
use App\Domain\Parroquias\Data\ParroquiasFinderResult;
use App\Domain\Parroquias\Repository\ParroquiasFinderRepository;

final class ParroquiasFinder
{
    private ParroquiasFinderRepository $repository;

    public function __construct(ParroquiasFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findParroquiass(int $municipio_id): ParroquiasFinderResult
    {
        // Input validation
        // ...

        $parroquiass = $this->repository->findParroquiass($municipio_id);

        return $this->createResult($parroquiass);
    }

    private function createResult(array $parroquiasRows): ParroquiasFinderResult
    {
        $result = new ParroquiasFinderResult();

        foreach ($parroquiasRows as $parroquiasRow) {
            $parroquias = new ParroquiasFinderItem();
            $parroquias->id = $parroquiasRow['id'];
            $parroquias->parroquia = $parroquiasRow['parroquia'];
            

            $result->parroquiass[] = $parroquias;
        }

        return $result;
    }
}
