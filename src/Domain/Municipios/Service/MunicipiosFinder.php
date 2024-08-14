<?php

namespace App\Domain\Municipios\Service;

use App\Domain\Municipios\Data\MunicipiosFinderItem;
use App\Domain\Municipios\Data\MunicipiosFinderResult;
use App\Domain\Municipios\Repository\MunicipiosFinderRepository;

final class MunicipiosFinder
{
    private MunicipiosFinderRepository $repository;

    public function __construct(MunicipiosFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findMunicipioss(int $estado_id): MunicipiosFinderResult
    {
        // Input validation
        // ...

        $municipioss = $this->repository->findMunicipioss($estado_id);

        return $this->createResult($municipioss);
    }

    private function createResult(array $municipiosRows): MunicipiosFinderResult
    {
        $result = new MunicipiosFinderResult();

        foreach ($municipiosRows as $municipiosRow) {
            $municipios = new MunicipiosFinderItem();
            $municipios->id = $municipiosRow['id'];
            $municipios->municipio = $municipiosRow['municipio'];
            

            $result->municipioss[] = $municipios;
        }

        return $result;
    }
}
